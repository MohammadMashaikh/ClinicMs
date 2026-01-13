<?php

namespace App\Livewire;

use App\Enums\PharmacyCategoriesEnums;
use App\Models\Pharmacy;
use Livewire\Component;
use Livewire\WithPagination;

class PharmacyDataTable extends Component
{

    use WithPagination;

    public $search = '';
    public $columns = [];
    public $category = '';
    public $status = '';

    public function render()
    {

        $medicines = Pharmacy::query()
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                  $query->where('medicine_name', 'like', "%{$this->search}%")
                     ->orWhere('generic_name', 'like', "%{$this->search}%");
                });
            })
            ->when($this->category, function($q) {
                $q->where('category', $this->category);
            })
            ->when($this->status, function($q) {
                if ($this->status === 'in_stock') {
                    $q->whereColumn('quantity', '>', 'reorder_level');
                } elseif ($this->status === 'low_stock') {
                    $q->whereColumn('quantity', '<=', 'reorder_level')
                    ->where('quantity', '>', 0);
                } elseif ($this->status === 'out_of_stock') {
                    $q->where('quantity', 0);
                }
            })
            ->paginate(10);


        $categories = PharmacyCategoriesEnums::cases();
        return view('livewire.pharmacy-data-table', compact('medicines', 'categories'));
    }


    public function updatedSearch()
    {
        $this->resetPage();
    }
}
