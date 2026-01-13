@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-6">

    <!-- Header: Patient & Doctor -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Patient Card -->
        <div class="bg-white shadow-md rounded-xl p-6 flex gap-4 items-center border border-gray-200">
            <div class="w-24 h-24 rounded-full overflow-hidden shadow-lg">
                @if($prescription->patient && $prescription->patient->user && $prescription->patient->user->getFirstMediaUrl('patient-image'))
                    <img src="{{ $prescription->patient->user->getFirstMediaUrl('patient-image') }}" 
                         alt="Patient Image" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-bold">
                        N/A
                    </div>
                @endif
            </div>
            <div class="space-y-1">
                <p class="text-2xl font-semibold text-gray-800">{{ $prescription->patient->user->full_name ?? 'N/A' }}</p>
                <p class="text-gray-500 font-medium flex items-center gap-2">
                    <i class="fa-solid fa-user"></i> Patient
                </p>
                <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-envelope"></i> {{ $prescription->patient->user->email ?? 'N/A' }}</p>
                <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-phone"></i> {{ $prescription->patient->user->phone ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Doctor Card -->
        <div class="bg-white shadow-md rounded-xl p-6 flex gap-4 items-center border border-gray-200">
            <div class="w-24 h-24 rounded-full overflow-hidden shadow-lg">
                @if($prescription->doctor && $prescription->doctor->user && $prescription->doctor->user->getFirstMediaUrl('doctor-image'))
                    <img src="{{ $prescription->doctor->user->getFirstMediaUrl('doctor-image') }}" 
                         alt="Doctor Image" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-bold">
                        N/A
                    </div>
                @endif
            </div>
            <div class="space-y-1">
                <p class="text-2xl font-semibold text-gray-800">{{ $prescription->doctor->user->full_name ?? 'N/A' }}</p>
                <p class="text-gray-500 font-medium flex items-center gap-2"><i class="fa-solid fa-user-md"></i> Doctor</p>
                <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-envelope"></i> {{ $prescription->doctor->user->email ?? 'N/A' }}</p>
                <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-phone"></i> {{ $prescription->doctor->user->phone ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Prescription Items -->
    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
        <h3 class="text-xl font-semibold text-gray-700 flex items-center gap-2 mb-4">
            <i class="fa-solid fa-pills text-green-600"></i> Medications
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($prescription->items as $item)
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition cursor-pointer"
                     onclick="Swal.fire({
                        title: '{{ addslashes($item->medicine_name) }}',
                        html: `
                            <p><strong>Dosage:</strong> {{ addslashes($item->dosage) }}</p>
                            <p><strong>Frequency:</strong> {{ addslashes($item->frequency) }}</p>
                            <p><strong>Duration:</strong> {{ addslashes($item->duration) }}</p>
                            <p><strong>Instructions:</strong> {{ addslashes($item->instructions ?: 'No instructions') }}</p>
                        `,
                        icon: 'info',
                        showCloseButton: true,
                     })">
                    <p class="text-gray-800 font-semibold">{{ $item->medicine_name }}</p>
                    <p class="text-gray-500 text-sm">
                        {{ $item->dosage }} • {{ $item->frequency }} • {{ $item->duration }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Prescription Date & Status -->
    <div class="flex justify-between items-center bg-white shadow-md rounded-xl p-6 border border-gray-200">
        <div class="text-gray-600 font-medium">
            <i class="fa-solid fa-calendar"></i> Created: {{ $prescription->created_at->format('d M Y') }}
        </div>
        @if($prescription->status)
            @php
                $statusClasses = [
                    'pending' => 'bg-yellow-100 text-yellow-700',
                    'confirmed' => 'bg-blue-100 text-blue-700',
                    'in progress' => 'bg-orange-100 text-orange-600',
                    'completed' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                ];
                $badgeClass = $statusClasses[strtolower($prescription->status)] ?? 'bg-gray-100 text-gray-700';
            @endphp
            <span class="px-4 py-2 rounded-full font-semibold {{ $badgeClass }}">
                {{ ucfirst($prescription->status) }}
            </span>
        @endif
    </div>

    <!-- Back Button -->
    <div>
        <a href="{{ route('prescription.list') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">
            <i class="fa-solid fa-arrow-left-long"></i> Back to List
        </a>
    </div>

</div>
@endsection


@php
    $pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Prescriptions List';
    $pageActionLink = route('prescription.list');
@endphp