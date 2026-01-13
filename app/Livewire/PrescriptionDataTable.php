<?php

namespace App\Livewire;

use App\Models\Prescription;
use Livewire\Component;
use Livewire\WithPagination;

class PrescriptionDataTable extends Component
{
    use WithPagination;

    public $search = '';
    public $columns = [];

    public function render()
    {
        $user = auth()->user();
        $prescriptions = Prescription::with('appointment', 'items');

        // Role-based filtering
        if ($user->hasRole('patient') && $user->patient) {
            // Filter by patient_id from patient table (not user id)
            $prescriptions->where('patient_id', $user->patient->id);
        }  elseif ($user->hasRole('super-admin')) {
            // Super admin sees all — no filter
        }

        // Search logic
        $prescriptions->when($this->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('doctor.user', function ($q1) use ($search) {
                    $q1->where('first_name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orWhereHas('patient.user', function ($q2) use ($search) {
                    $q2->where('first_name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        });

        return view('livewire.prescription-data-table', [
            'prescriptions' => $prescriptions->paginate(10),
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
