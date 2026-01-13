<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    

    public function list()
    {
        return view('prescriptions.list');
    }


    public function show(Prescription $prescription)
    {
        return view('prescriptions.show', compact('prescription'));
    }
}
