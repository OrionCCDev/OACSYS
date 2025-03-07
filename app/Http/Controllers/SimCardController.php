<?php

namespace App\Http\Controllers;

use App\Models\SimCard;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Imports\SimCardImport;
use Maatwebsite\Excel\Facades\Excel;

class SimCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    // public function import(Request $request)
    // {
    //     $file = $request->file('excel_file');
    //     Excel::import(new SimCardImport, $file);

    //     return redirect()->back()->with('success', 'SimCards updated successfully');
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $simCards = SimCard::all();
        $employees = Employee::all();

        return view('sim_card.create', compact('simCards', 'employees'));
        // $simEmployeeMap = array_map(function($value) {
        //     return (string)$value;
        // }, [
        //     '555657340' => 3345,
        //     '557013093' => 2758,
        //     '558493858' => 198,
        //     '559495036' => 693,
        //     '529112135' => 3170,
        //     '522815637' => 2975,
        //     '588486622' => 3299,
        //     '556432387' => 2567,
        //     '552718634' => 2839,
        //     '552716835' => 941,
        //     '552715840' => 2775,
        //     '522812771' => 2458,
        //     '555657890' => 466,
        //     '555657098' => 1092,
        //     '555653702' => 540,
        //     '555654092' => 795,
        //     '555653129' => 812,
        //     '555653084' => 858,
        //     '552718934' => 2854,
        //     '525801176' => 162,
        //     '525801164' => 406,
        //     '529470630' => 442,
        //     '552648430' => 2803,
        //     '529793681' => 614,
        //     '529674332' => 3385,
        //     '529375768' => 218,
        //     '525798425' => 840,
        //     '526458186' => 2849,
        //     '529244982' => 1036,
        //     '559360612' => 205,
        //     '526458184' => 637,
        //     '526458201' => 103,
        //     '559714823' => 3325,
        //     '556432381' => 3367,
        //     '558494532' => 915,
        //     '554945036' => 2005,
        //     '528310985' => 282,
        //     '557013124' => 681,
        //     '555652790' => 847,
        //     '552306201' => 915,
        //     '526458185' => 2821,
        //     '526458198' => 2810,
        //     '552701205' => 226,
        //     '526458190' => 121,
        //     '526458191' => 1734,
        //     '526458196' => 2892,
        //     '529245029' => 330,
        //     '529244972' => 1734,
        //     '552702297' => 2847,
        //     '552706773' => 2799,
        //     '558494613' => 861,
        //     '526414858' => 2545,
        //     '526458182' => 792,
        //     '559740536' => 430,
        //     '529103091' => 3127,
        //     '556432382' => 81,
        //     '556432372' => 2891,
        //     '552314793' => 731,
        //     '558493962' => 838,
        //     '559718235' => 633,
        //     '559732054' => 167,
        //     '529245092' => 56,
        //     '558892685' => 444,
        //     '552695383' => 2844,
        //     '552718605' => 2780,
        //     '552718406' => 380,
        //     '558795061' => 421,
        //     '552718395' => 2793,
        //     '526922161' => 2776,
        //     '529112156' => 471,
        //     '529103039' => 2972,
        //     '526458194' => 3120,
        //     '557013121' => 1504,
        //     '529112141' => 3034,
        //     '558493361' => 787,
        //     '559732064' => 2789,
        //     '558795064' => 680,
        //     '555652718' => 151,
        //     '522869743' => 213,
        //     '522870134' => 2940,
        //     '522870365' => 131,
        //     '522870465' => 2852,
        //     '522871059' => 2937,
        //     '522871064' => 3248,
        //     '521728239' => 3193,
        //     '522815693' => 3306,
        //     '522816597' => 3061,
        //     '522817069' => 2722,
        //     '522814597' => 425,
        //     '522814930' => 2749,
        //     '522814936' => 3019,
        //     '522814975' => 2951,
        //     '528790698' => 3472,
        //     '528311276' => 3059,
        //     '529112153' => 2999,
        //     '557013021' => 3387,
        //     '582649180' => 3488,
        //     '582651403' => 808,
        //     '521811365' => 3287,
        //     '521812032' => 3228,
        //     '521812589' => 3210,
        //     '521812863' => 684,
        //     '521813496' => 446,
        //     '521813797' => 3130,
        //     '521813875' => 3249,
        //     '521814003' => 3140,
        //     '521814500' => 3229,
        //     '521814749' => 3250,
        //     '521815425' => 3232,
        //     '521815806' => 3231,
        //     '521815963' => 3052,
        //     '521816549' => 3201,
        //     '521816634' => 764,
        //     '521816755' => 3304,
        //     '521816971' => 3183,
        //     '521817374' => 3283,
        //     '521819284' => 8234,
        //     '521819325' => 3119,
        //     '558794503' => 808,
        //     '588486161' => 2506,
        //     '588486248' => 3302,
        //     '588486414' => 3328,
        //     '588486418' => 3342,
        //     '588486456' => 3191,
        //     '588486496' => 3341,
        //     '588486554' => 2012,
        //     '588486558' => 3326,
        //     '588486624' => 3332,
        //     '588486638' => 121,
        //     '588486645' => 3348,
        //     '588486687' => 3344,
        //     '588486698' => 693,
        //     '588487004' => 2545,
        //     '588487078' => 3343,
        //     '588487244' => 3231,
        //     '588487272' => 3358,
        //     '588487434' => 3292,
        //     '588487545' => 3357,
        //     '588487728' => 3306,
        //     '588487749' => 3308,
        //     '588487768' => 3334,
        //     '526936193' => 3139,
        //     '529112159' => 3311
        // ]);

        // $chunks = array_chunk($simEmployeeMap, 50, true);

        // foreach ($chunks as $chunk) {
        //     foreach ($chunk as $simNumber => $employeeId) {
        //         $employeeExists = Employee::where('employee_id', $employeeId)->exists();

        //         if ($employeeExists) {
        //             $emp = Employee::where('employee_id', $employeeId)->first();
        //             SimCard::where('sim_number', $simNumber)
        //                 ->update([
        //                     'employee_id' => $emp->id,
        //                     'status' => 'taken'
        //                 ]);
        //         }
        //     }
        // }

        // return redirect()->back()->with('success', 'SIM cards updated successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sim_card_id' => 'required|exists:sim_cards,id',
            'employee_id' => 'required|exists:employees,id'
        ]);

        $simCard = SimCard::findOrFail($validated['sim_card_id']);
        $simCard->update([
            'employee_id' => $validated['employee_id'],
            'status' => 'taken',
        ]);

        return redirect()->route('sim.index')
            ->with('success', 'SIM Card assigned successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SimCard $simCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SimCard $simCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SimCard $simCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SimCard $simCard)
    {
        //
    }
}
