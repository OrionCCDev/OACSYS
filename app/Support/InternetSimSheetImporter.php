<?php

namespace App\Support;

use App\Models\InternetSim;
use App\Models\Router;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Loads the site internet SIM sheet into the system.
 *
 * Re-running it is safe and is the point: a line is matched on SIM number,
 * account site and SIM S/N together, and updated rather than duplicated. So
 * the same sheet can be uploaded again after a correction, and a later
 * month's sheet only changes what actually changed.
 *
 * The serial alone is deliberately NOT the identity. Real sheets carry the
 * same S/N on two different lines - a copy-paste slip - and keying on it
 * would silently drop one of them. Every row is imported; duplicated serials
 * are reported instead so they can be corrected at the source.
 *
 * Routers are matched on their serial. The sheet has no router name, so the
 * serial is used as the name; rename them afterwards if you want something
 * friendlier.
 */
class InternetSimSheetImporter
{
    /** Header text => the field it feeds. Matched loosely, so wording can drift. */
    private const COLUMNS = [
        'sim number' => 'sim_number',
        'providor' => 'sim_provider',
        'provider' => 'sim_provider',
        'acount name' => 'account_name',
        'account name' => 'account_name',
        'account site' => 'account_site',
        'sim status' => 'line_active',
        'sim s/n' => 'sim_serial',
        'contract no' => 'contract_no',
        'router s/n' => 'router_serial',
        'remark' => 'remark',
    ];

    public array $created = [];
    public array $updated = [];
    public array $warnings = [];
    public int $routersCreated = 0;

    /**
     * @param  string  $path      the .xlsx file
     * @param  ?Carbon $recordedAt back-date the rows so they appear on that
     *                            month's report; defaults to now
     */
    public function import(string $path, ?Carbon $recordedAt = null): self
    {
        $recordedAt ??= Carbon::now();

        $reader = IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);
        $rows = $reader->load($path)->getSheet(0)->toArray(null, true, false, false);

        $map = $this->findHeader($rows);
        $seen = [];
        $serials = [];

        foreach ($rows as $i => $raw) {
            if ($i <= $map['row']) {
                continue;
            }

            $row = $this->readRow($raw, $map['columns']);

            // A line needs at least a number or a serial to mean anything.
            if (blank($row['sim_number']) && blank($row['sim_serial'])) {
                continue;
            }

            $key = $this->keyFor($row);
            if (isset($seen[$key])) {
                $this->warnings[] = sprintf(
                    'Row %d is an exact repeat of row %d (%s, %s) - imported once.',
                    $i + 1,
                    $seen[$key],
                    $row['sim_number'] ?: 'no number',
                    $row['account_site'] ?: 'no site'
                );
                continue;
            }
            $seen[$key] = $i + 1;

            // Two different lines sharing a serial is almost always a slip in
            // the sheet. Both are imported; the clash is reported so it can be
            // fixed at source rather than quietly losing one of them.
            if (filled($row['sim_serial'])) {
                if (isset($serials[$row['sim_serial']])) {
                    $this->warnings[] = sprintf(
                        'Row %d has the same SIM S/N as row %d (%s) - both imported, but one is probably a typo.',
                        $i + 1,
                        $serials[$row['sim_serial']],
                        $row['sim_serial']
                    );
                } else {
                    $serials[$row['sim_serial']] = $i + 1;
                }
            }

            if (blank($row['sim_number'])) {
                $this->warnings[] = sprintf('Row %d has no SIM number (%s).', $i + 1, $row['account_site'] ?: 'no site');
            }

            $router = $this->routerFor($row, $recordedAt);
            $this->saveSim($row, $router, $recordedAt, $i + 1);
        }

        return $this;
    }

    /** Finds the header row wherever it sits, and which column holds what. */
    private function findHeader(array $rows): array
    {
        foreach ($rows as $i => $raw) {
            $columns = [];
            foreach ($raw as $c => $cell) {
                $key = strtolower(trim((string) $cell));
                if (isset(self::COLUMNS[$key])) {
                    $columns[self::COLUMNS[$key]] = $c;
                }
            }

            if (isset($columns['sim_number'], $columns['account_site'])) {
                return ['row' => $i, 'columns' => $columns];
            }
        }

        throw new \RuntimeException(
            'Could not find the header row. It needs at least "SIM NUMBER" and "ACCOUNT SITE" columns.'
        );
    }

    private function readRow(array $raw, array $columns): array
    {
        $get = fn (string $field) => isset($columns[$field]) && isset($raw[$columns[$field]])
            ? trim((string) $raw[$columns[$field]])
            : '';

        return [
            'sim_number' => $get('sim_number'),
            'sim_provider' => $get('sim_provider'),
            'account_name' => $get('account_name'),
            'account_site' => $get('account_site'),
            // "NOT active" / "not active" both mean the line is down.
            'line_active' => !str_contains(strtolower($get('line_active')), 'not'),
            'sim_serial' => $get('sim_serial'),
            'contract_no' => $get('contract_no'),
            'router_serial' => $get('router_serial'),
            'remark' => $get('remark'),
        ];
    }

    /**
     * What makes a line that line: its number, where it is, and its serial.
     * Only rows identical across all three are the same record.
     */
    private function keyFor(array $row): string
    {
        return $row['sim_number'] . '|' . $row['account_site'] . '|' . $row['sim_serial'];
    }

    private function routerFor(array $row, Carbon $recordedAt): ?Router
    {
        if (blank($row['router_serial'])) {
            return null;
        }

        $router = Router::where('serial_number', $row['router_serial'])->first();

        if (!$router) {
            $router = Router::create([
                // No router name on the sheet, so the serial stands in for one.
                'name' => $row['router_serial'],
                'serial_number' => $row['router_serial'],
                'isp_provider' => $row['sim_provider'] ?: null,
                'account_site' => $row['account_site'] ?: null,
                'status' => 'active',
                'main_image' => 'default_device.png',
                'created_at' => $recordedAt,
                'updated_at' => $recordedAt,
            ]);
            $this->routersCreated++;
        }

        return $router;
    }

    private function saveSim(array $row, ?Router $router, Carbon $recordedAt, int $rowNumber): void
    {
        $attributes = [
            'sim_number' => $row['sim_number'] ?: '-',
            'sim_provider' => $row['sim_provider'] ?: '-',
            'account_name' => $row['account_name'] ?: null,
            'account_site' => $row['account_site'] ?: null,
            'line_active' => $row['line_active'],
            'sim_serial' => $row['sim_serial'] ?: null,
            'contract_no' => $row['contract_no'] ?: null,
            'remark' => $row['remark'] ?: null,
            'router_id' => $router?->id,
        ];

        $existing = InternetSim::where('sim_number', $attributes['sim_number'])
            ->where('account_site', $row['account_site'] ?: null)
            ->where('sim_serial', $row['sim_serial'] ?: null)
            ->first();

        if ($existing) {
            $existing->update($attributes);
            $this->updated[] = $rowNumber;

            return;
        }

        InternetSim::create($attributes + [
            'created_at' => $recordedAt,
            'updated_at' => $recordedAt,
        ]);
        $this->created[] = $rowNumber;
    }

    public function summary(): string
    {
        return sprintf(
            '%d line(s) added, %d updated, %d router(s) created.',
            count($this->created),
            count($this->updated),
            $this->routersCreated
        );
    }
}
