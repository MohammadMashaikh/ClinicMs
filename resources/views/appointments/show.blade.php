@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="max-w-6xl mx-auto p-6">


   <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4">
        
        <!-- Title Card -->
        <div class="flex-1 bg-gradient-to-r from-blue-50 to-white border-l-4 border-blue-600 p-4 rounded-xl shadow-md">
            <h4 class="text-xl md:text-2xl font-semibold text-gray-800 flex items-center gap-3">
                <i class="fa-solid fa-calendar-check text-blue-600 text-2xl"></i>
                <span>
                    Appointment Details
                </span>
            </h4>
            <p class="mt-2 text-gray-600 text-sm md:text-base">
                Patient: <span class="text-purple-600 font-medium">{{ $appointment->patient->user->full_name }}</span>  
                &nbsp;|&nbsp; 
                Doctor: <span class="text-pink-600 font-medium">{{ $appointment->doctor->user->full_name }}</span>
            </p>
        </div>

        <!-- Back Button -->
        <div class="flex-shrink-0">
            <a href="{{ route('appointment.list') }}" 
            class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-3 rounded-xl text-sm font-medium transition-all duration-150 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>

    </div>


    {{-- Main Card --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
        {{-- Top Grid: Patient & Doctor --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">

            {{-- Patient --}}
            <div class="flex gap-6 items-center">
                <div class="w-24 h-24 rounded-full overflow-hidden shadow-lg">
                    @if($appointment->patient->user && $appointment->patient->user->getFirstMediaUrl('patient-image'))
                        <img src="{{ $appointment->patient->user->getFirstMediaUrl('patient-image') }}" 
                             alt="Patient Image" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-bold">
                            N/A
                        </div>
                    @endif
                </div>
                <div class="space-y-1">
                    <p class="text-2xl font-semibold text-gray-800">{{ $appointment->patient->user->full_name }}</p>
                    <p class="text-gray-500 font-medium flex items-center gap-2">
                        <i class="fa-solid fa-user"></i> Patient
                    </p>
                    <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-envelope"></i> {{ $appointment->patient->user->email ?? 'N/A' }}</p>
                    <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-phone"></i> {{ $appointment->patient->user->phone ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Doctor --}}
            <div class="flex gap-6 items-center">
                <div class="w-24 h-24 rounded-full overflow-hidden shadow-lg">
                     @if($appointment->doctor->user && $appointment->doctor->user->getFirstMediaUrl('doctor-image'))
                        <img src="{{ $appointment->doctor->user->getFirstMediaUrl('doctor-image') }}" 
                             alt="Doctor Image" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-user-doctor"></i>
                    @endif
                </div>
                <div class="space-y-1">
                    <p class="text-2xl font-semibold text-gray-800">{{ $appointment->doctor->user->full_name }}</p>
                    <p class="text-gray-500 font-medium flex items-center gap-2"><i class="fa-solid fa-user-md"></i> Doctor</p>
                    <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-envelope"></i> {{ $appointment->doctor->user->email }}</p>
                    <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-phone"></i> {{ $appointment->doctor->user->phone }}</p>
                </div>
            </div>

        </div>

        {{-- Divider --}}
        <div class="border-t border-gray-200"></div>

        {{-- Appointment Details --}}
        <div class="p-8 space-y-6">

            <h3 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-blue-600"></i>
                Appointment Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex flex-col gap-2">
                    <p class="text-gray-500 font-medium">Day</p>
                    <p class="text-gray-800 font-semibold">{{ $appointment->day_of_week }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex flex-col gap-2">
                    <p class="text-gray-500 font-medium">Time</p>
                    <p class="text-gray-800 font-semibold">{{ $appointment->start_time->format('H:i A') }} - {{ $appointment->end_time->format('H:i A') }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex flex-col gap-2">
                    <p class="text-gray-500 font-medium">Status</p>
                    @php
                        $statusClasses = [
                            'confirmed'   => 'bg-blue-100 text-blue-700',
                            'pending'     => 'bg-yellow-100 text-yellow-700',
                            'in progress' => 'bg-orange-100 text-orange-700',
                            'cancelled'   => 'bg-red-100 text-red-700',
                            'completed'   => 'bg-green-100 text-green-700',
                        ];
                        $status = strtolower($appointment->status);
                        $badgeClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="inline-block px-4 py-2 rounded-full font-semibold {{ $badgeClass }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            </div>

            @if($appointment->reason_for_visit)
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <p class="text-gray-500 font-medium flex items-center gap-2">
                    <i class="fa-solid fa-sticky-note text-yellow-500"></i> Reason For Visit
                </p>
                <p class="text-gray-800">{{ $appointment->reason_for_visit }}</p>
            </div>
            @endif


      @if($appointment->prescription && $appointment->prescription->items->count())
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-700 flex items-center gap-2 mb-4">
            <i class="fa-solid fa-pills text-green-600"></i> Prescription Details
        </h3>

        <div class="space-y-6">
            @foreach ($appointment->prescription->items as $index => $item)
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-capsules text-blue-600"></i>
                            Medicine #{{ $index + 1 }}
                        </h4>
                        <span class="text-sm px-3 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                            {{ $item->duration }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                            <p class="text-gray-500 text-sm font-medium">Medicine Name</p>
                            <p class="text-gray-800 font-semibold">{{ $item->medicine_name }}</p>
                        </div>

                        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                            <p class="text-gray-500 text-sm font-medium">Dosage</p>
                            <p class="text-gray-800 font-semibold">{{ $item->dosage }}</p>
                        </div>

                        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                            <p class="text-gray-500 text-sm font-medium">Frequency</p>
                            <p class="text-gray-800 font-semibold">{{ $item->frequency }}</p>
                        </div>
                    </div>

                    @if($item->instructions)
                        <div class="mt-4 bg-white p-3 rounded-lg border border-gray-100">
                            <p class="text-gray-500 text-sm font-medium flex items-center gap-2">
                                <i class="fa-solid fa-notes-medical text-yellow-500"></i> Instructions
                            </p>
                            <p class="text-gray-800 font-medium leading-relaxed">{{ $item->instructions }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif



        </div>

        {{-- Divider --}}
        <div class="border-t border-gray-200"></div>

        {{-- Action Buttons --}}
        <div class="p-8 flex flex-wrap gap-4 justify-start">

            @if(auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super-admin'))
                @if($appointment->status == 'In Progress')
                    <button type="button" id="openPrescriptionModal"
                        class="flex items-center gap-2 px-6 py-3 bg-green-800 text-white rounded-xl hover:bg-green-700 font-semibold">
                        <i class="fa-solid fa-check-double"></i> Complete the Appointment
                    </button>
                @endif
            @endif

            @if(auth()->user()->hasRole('patient') || auth()->user()->hasRole('super-admin'))
                @if($appointment->status != 'Cancelled' && $appointment->status != 'In Progress' && $appointment->status != 'Completed')
                    <form action="{{ route('appointment.cancel', $appointment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-semibold">
                            <i class="fa-solid fa-xmark"></i> Cancel Appointment
                        </button>
                    </form>
                @endif
            @endif
        </div>

        {{-- Prescription Modal --}}
        <div id="prescriptionModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl w-full max-w-2xl p-6 shadow-xl">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-pills text-green-700"></i> Add Prescription
                </h2>

                <form id="prescriptionForm" action="{{ route('appointment.complete', $appointment->id) }}" method="POST">
                    @csrf

                    <div id="medicineContainer" class="space-y-4">
                        <div class="grid grid-cols-4 gap-2 medicine-row">
                            <input type="text" name="medicine_name[]" placeholder="Medicine Name" required
                                class="border rounded-lg p-2 col-span-1">
                            <input type="text" name="dosage[]" placeholder="Dosage (e.g., 500mg)" required
                                class="border rounded-lg p-2 col-span-1">
                            <input type="text" name="frequency[]" placeholder="Frequency (e.g., 2x/day)" required
                                class="border rounded-lg p-2 col-span-1">
                            <input type="text" name="duration[]" placeholder="Duration (e.g., 5 days)" required
                                class="border rounded-lg p-2 col-span-1">
                            <textarea name="instructions[]" placeholder="Instructions ..."
                                class="border rounded-lg p-2 col-span-4"></textarea>
                        </div>
                    </div>

                    <button type="button" id="addMedicineRow"
                        class="mt-3 text-blue-600 hover:underline text-sm flex items-center gap-1">
                        <i class="fa-solid fa-plus"></i> Add Another Medicine
                    </button>

                    <div class="mt-6 flex justify-end gap-4">
                        <button type="button" id="closePrescriptionModal"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg text-gray-700 font-semibold">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg font-semibold">
                            Save & Complete
                        </button>
                    </div>
                </form>
            </div>
        </div>






    </div>

</div>
@endsection


@php

$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Appointments List';
$pageActionLink = route('appointment.list');


@endphp




@section('custom-js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    // Open modal
    $('#openPrescriptionModal').click(function () {
        $('#prescriptionModal').removeClass('hidden').addClass('flex');
    });

    // Close modal
    $('#closePrescriptionModal').click(function () {
        $('#prescriptionModal').addClass('hidden').removeClass('flex');
    });

    // Add new medicine row
    $('#addMedicineRow').click(function () {
        let newRow = `
            <div class="grid grid-cols-4 gap-2 medicine-row">
                <input type="text" name="medicine_name[]" placeholder="Medicine Name" required
                    class="border rounded-lg p-2 col-span-1">
                <input type="text" name="dosage[]" placeholder="Dosage (e.g., 500mg)" required
                    class="border rounded-lg p-2 col-span-1">
                <input type="text" name="frequency[]" placeholder="Frequency (e.g., 2x/day)" required
                    class="border rounded-lg p-2 col-span-1">
                <input type="text" name="duration[]" placeholder="Duration (e.g., 5 days)" required
                    class="border rounded-lg p-2 col-span-1">
                <textarea name="instructions[]" placeholder="Instructions ..."
                class="border rounded-lg p-2 col-span-1"></textarea>
                <button type="button" class="removeRow text-red-600 hover:text-red-800 text-sm col-span-4 text-left mt-1">
                    <i class="fa-solid fa-trash"></i> Remove
                </button>
            </div>
        `;
        $('#medicineContainer').append(newRow);
    });

    // Remove medicine row
    $(document).on('click', '.removeRow', function () {
        $(this).closest('.medicine-row').remove();
    });

});
</script>
@endsection
