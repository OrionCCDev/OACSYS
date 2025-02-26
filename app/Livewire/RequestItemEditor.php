<?php

namespace App\Livewire;

use Livewire\Component;

class RequestItemEditor extends Component
{
    public $request;
    public $items = [];

    public function mount($request)
    {
        $this->request = $request;
        $this->items = $request->items->map(function($item) {
            return [
                'id' => $item->id,
                'item_type' => $item->item_type,
                'quantity' => $item->quantity,
                'request_for_type' => $item->request_for_type,
                'requested_for_name' => $item->requested_for_name,
                'requested_for_id' => $item->requested_for_id,
                'requested_for_position' => $item->requested_for_position,
                'notes' => $item->notes ?? ''
            ];
        })->toArray();
    }

    public function addItem()
    {
        $this->items[] = [
            'id' => null,
            'item_type' => '',
            'quantity' => 1,
            'request_for_type' => '',
            'requested_for_name' => '',
            'requested_for_id' => '',
            'requested_for_position' => '',
            'notes' => ''
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $this->validate([
            'items.*.item_type' => 'required',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.request_for_type' => 'nullable',
            'items.*.requested_for_name' => 'required',
            'items.*.requested_for_id' => 'nullable',
            'items.*.requested_for_position' => 'nullable',
            'items.*.notes' => 'nullable'
        ]);

        $this->request->items()->delete();
        foreach($this->items as $item) {
            $this->request->items()->create($item);
        }

        $this->dispatch('items-updated');
        return redirect()->route('asset-request.show', $this->request->id);

    }

    public function render()
    {
        return view('livewire.request-item-editor');
    }
}
