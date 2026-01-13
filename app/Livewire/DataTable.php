<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;

    public $columns = [];
    public $model;
    public $with = [];
    public $title = '';
    public $search = '';


    public function render()
    {
        $data = ($this->model)::with($this->with)?->when($this->search, function ($query) {
            $query->whereHas('user', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%');
                $q->orWhere('last_name', 'like', '%' . $this->search . '%');
                $q->orWhere('full_name', 'like', '%' . $this->search . '%');
            });
        })->paginate(5);
        return view('livewire.data-table', compact('data'));
    }



    public function updateSearch($value)
    {
        $this->search = $value;
        $this->resetPage();
    }


    
}
