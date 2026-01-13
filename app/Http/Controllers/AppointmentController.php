<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Prescription;
use App\Models\PrescriptionItems;
use App\Models\Specialization;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    
    
    public function index()
    {
        return view('appointments.index');
    }


    public function create()
    {
        $specializations = Specialization::all();
        return view('appointments.create', compact('specializations'));
    }



    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id'   => 'required|exists:patients,id',
            'doctor_id'    => 'required|exists:doctors,id',
            'day_of_week'  => 'required|string',
            'date'         => 'required|date',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'reason_for_visit' => 'required|string'
        ]);


        Appointment::create([
            'patient_id'    => $validatedData['patient_id'],
            'doctor_id'     => $validatedData['doctor_id'],
            'day_of_week'   => $validatedData['day_of_week'],
            'date'          => $validatedData['date'],
            'start_time'    => $validatedData['start_time'],
            'end_time'      => $validatedData['end_time'],
            'reason_for_visit' => $validatedData['reason_for_visit'],
            'status'        => 'Pending'
        ]);

     
        return redirect()->route('appointment.list')->with('success', 'Appointment booked successfully!');
    }



    public function getDoctorBySpec($id)
    {
        $doctor = Doctor::with('user.media', 'schedules', 'primarySpecialization')->where('primary_specialization_id', $id)->get();
        return response()->json($doctor);
    }



    public function confirmAppointment(Appointment $appointment)
    {
        $appointment->status = 'Confirmed';
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment Confirmed');
    }


    public function cancelAppointment(Appointment $appointment)
    {
        $appointment->status = 'Cancelled';
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment Cancelled');
    }

    public function progressAppointment(Appointment $appointment)
    {
        $appointment->status = 'In Progress';
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment set to In Progress');
    }


    public function completeAppointment(Request $request, Appointment $appointment)
    {
        // Validate only medicine details
        $validatedData = $request->validate([
            'medicine_name' => 'required|array',
            'medicine_name.*' => 'required|string',
            'dosage' => 'required|array',
            'dosage.*' => 'required|string',
            'frequency' => 'required|array',
            'frequency.*' => 'required|string',
            'duration' => 'required|array',
            'duration.*' => 'required|string',
            'instructions' => 'nullable|array',
            'instructions.*' => 'nullable|string'
        ]);

        // Create prescription
        $prescription = Prescription::create([
            'appointment_id' => $appointment->id,
            'doctor_id' => $appointment->doctor_id,
            'patient_id' => $appointment->patient_id,
        ]);

        // Save all prescription items (loop through arrays)
        foreach ($validatedData['medicine_name'] as $index => $medicineName) {
            PrescriptionItems::create([
                'prescription_id' => $prescription->id,
                'medicine_name'   => $medicineName,
                'dosage'          => $validatedData['dosage'][$index],
                'frequency'       => $validatedData['frequency'][$index],
                'duration'        => $validatedData['duration'][$index],
                'instructions'    => $validatedData['instructions'][$index] ?? null,
            ]);
        }

        // Mark appointment as completed
        $appointment->update(['status' => 'Completed']);

        return redirect()->route('appointment.list')->with('success', 'Appointment completed and prescription saved successfully.');
    }



    public function getBookedSlots($doctorId)
    {
        $booked = Appointment::where('doctor_id', $doctorId)
        ->whereIn('status', ['Pending', 'Confirmed', 'In Progress', 'Completed'])
        ->get(['date', 'start_time', 'end_time'])
        ->map(function ($slot) {
            return [
                'date' => $slot->date->format('Y-m-d'),
                'start_time' => date('H:i', strtotime($slot->start_time)),
                'end_time' => date('H:i', strtotime($slot->end_time)),
            ];
        });

        return response()->json($booked);
    }

    
}
