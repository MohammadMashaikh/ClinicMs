@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="card p-6">
    <div class="flex items-center justify-between mb-6">
        <h4 class="text-xl font-semibold text-gray-700">
            <i class="fa-solid fa-user-patient text-blue-600 mr-2"></i> patient Profile
        </h4>
        <a href="{{ route('patient.list') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
           <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- Profile Header --}}
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8 mb-10">
        <div class="relative">
            <img src="{{ $patient->user->getFirstMediaUrl('patient-image') }}" 
                 class="w-40 h-40 object-cover rounded-full border border-gray-300 shadow-sm"
                 alt="patient Image">
        </div>
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $patient->user->full_name }}</h2>
            <p class="text-gray-500 text-sm"><i class="fa-solid fa-envelope mr-2 text-blue-600"></i>{{ $patient->user->email }}</p>
            <p class="text-gray-500 text-sm mt-1"><i class="fa-solid fa-phone mr-2 text-blue-600"></i>{{ $patient->user->phone }}</p>
        </div>
    </div>

    {{-- Personal Information --}}
    <div class="mb-10">
        <h5 class="text-lg font-medium text-gray-600 mb-4 flex items-center">
            <i class="fa-solid fa-id-card text-blue-600 mr-2"></i> Personal Information
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div>
                <p class="text-gray-500 text-sm">Date of Birth</p>
                <p class="text-gray-800 font-medium">{{ $patient->user->date_of_birth->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Gender</p>
                <p class="text-gray-800 font-medium">{{ $patient->user->gender->value }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Address</p>
                <p class="text-gray-800 font-medium">{{ $patient->user->address }}</p>
            </div>
        </div>
    </div>

    {{-- Contact Information --}}
    <div class="mb-10">
        <h5 class="text-lg font-medium text-gray-600 mb-4 flex items-center">
            <i class="fa-solid fa-address-book text-blue-600 mr-2"></i> Emergency Contact
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div>
                <p class="text-gray-500 text-sm">Name</p>
                <p class="text-gray-800 font-medium">{{ $patient->user->emergency_contact_name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Phone</p>
                <p class="text-gray-800 font-medium">{{ $patient->user->emergency_contact_phone }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Email</p>
                <p class="text-gray-800 font-medium">{{ $patient->user->emergency_contact_email ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Relation</p>
                <p class="text-gray-800 font-medium">
                    {{ $patient->user->emergency_contact_relation }}
                    @if ($patient->user->emergency_contact_relation_other)
                        ({{ $patient->user->emergency_contact_relation_other }})
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Medical Information --}}
    <div class="mb-10">
        <h5 class="text-lg font-medium text-gray-600 mb-4 flex items-center">
            <i class="fa-solid fa-briefcase text-blue-600 mr-2"></i> Medical Information
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div>
                <p class="text-gray-500 text-sm">Height</p>
                <p class="text-gray-800 font-medium">{{ $patient->height }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Weight</p>
                <p class="text-gray-800 font-medium">{{ $patient->weight }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Allergic</p>
                <p class="text-gray-800 font-medium">{{ $patient->allergies ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Current Medications</p>
                <p class="text-gray-800 font-medium">{{ $patient->current_medications ?? 'N/A' }}</p>
            </div>
              <div>
                <p class="text-gray-500 text-sm">Chronic Diseases</p>
                <p class="text-gray-800 font-medium">{{ $patient->chronic_diseases ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Past Surgeries</p>
                <p class="text-gray-800 font-medium">{{ $patient->past_surgeries ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Previous Hospitalizations</p>
                <p class="text-gray-800 font-medium">{{ $patient->previous_hospitalizations ?? 'N/A' }}</p>
            </div>
           
            <div>
                <p class="text-gray-500 text-sm">Family Medical History</p>
                <p class="text-gray-800 font-medium">{{ is_array($patient->family_medical_history) ? implode(', ', $patient->family_medical_history) : $patient->family_medical_history }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Family History Notes</p>
                <p class="text-gray-800 font-medium">{{ $patient->family_history_notes ?? 'N/A'}}</p>
            </div>
        </div>
    </div>


    {{-- Insurance Information --}}
    <div class="mb-10">
        <h5 class="text-lg font-medium text-gray-600 mb-4 flex items-center">
            <i class="fa-solid fa-briefcase text-blue-600 mr-2"></i> Insurance Information
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div>
                <p class="text-gray-500 text-sm">Insurance Provider</p>
                <p class="text-gray-800 font-medium">{{ $patient->insurance_provider }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Policy Number</p>
                <p class="text-gray-800 font-medium">{{ $patient->policy_number }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Policy Holder Name</p>
                <p class="text-gray-800 font-medium">{{ $patient->policy_holder_name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Relationship to Patient</p>
                <p class="text-gray-800 font-medium">{{ $patient->relationship_to_patient }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Insurance Phone Number</p>
                <p class="text-gray-800 font-medium">{{ $patient->insurance_phone_number }}</p>
            </div>
        </div>
    </div>

</div>
@endsection


@php
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> patients List';
$pageActionLink = route('patient.list');
@endphp
