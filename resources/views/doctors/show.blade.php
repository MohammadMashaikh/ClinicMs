@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="card p-6">
    <div class="flex items-center justify-between mb-6">
        <h4 class="text-xl font-semibold text-gray-700">
            <i class="fa-solid fa-user-doctor text-blue-600 mr-2"></i> Doctor Profile
        </h4>
        <a href="{{ route('doctor.list') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
           <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- Profile Header --}}
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8 mb-10">
        <div class="relative">
            <img src="{{ $doctor->user->getFirstMediaUrl('doctor-image') }}" 
                 class="w-40 h-40 object-cover rounded-full border border-gray-300 shadow-sm"
                 alt="Doctor Image">
        </div>
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $doctor->user->full_name }}</h2>
            <p class="text-gray-500 text-sm"><i class="fa-solid fa-envelope mr-2 text-blue-600"></i>{{ $doctor->user->email }}</p>
            <p class="text-gray-500 text-sm mt-1"><i class="fa-solid fa-phone mr-2 text-blue-600"></i>{{ $doctor->user->phone }}</p>
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
                <p class="text-gray-800 font-medium">{{ $doctor->user->date_of_birth->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Gender</p>
                <p class="text-gray-800 font-medium">{{ $doctor->user->gender->value }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Address</p>
                <p class="text-gray-800 font-medium">{{ $doctor->user->address }}</p>
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
                <p class="text-gray-800 font-medium">{{ $doctor->user->emergency_contact_name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Phone</p>
                <p class="text-gray-800 font-medium">{{ $doctor->user->emergency_contact_phone }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Email</p>
                <p class="text-gray-800 font-medium">{{ $doctor->user->emergency_contact_email ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Relation</p>
                <p class="text-gray-800 font-medium">
                    {{ $doctor->user->emergency_contact_relation }}
                    @if ($doctor->user->emergency_contact_relation_other)
                        ({{ $doctor->user->emergency_contact_relation_other }})
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Professional Details --}}
    <div class="mb-10">
        <h5 class="text-lg font-medium text-gray-600 mb-4 flex items-center">
            <i class="fa-solid fa-briefcase text-blue-600 mr-2"></i> Professional Details
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div>
                <p class="text-gray-500 text-sm">Primary Specialization</p>
                <p class="text-gray-800 font-medium">{{ $doctor->primarySpecialization->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Secondary Specialization</p>
                <p class="text-gray-800 font-medium">{{ $doctor->secondarySpecialization->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">License Number</p>
                <p class="text-gray-800 font-medium">{{ $doctor->license_number }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">License Expiry Date</p>
                <p class="text-gray-800 font-medium">{{ $doctor->license_expiry_date->format('d M Y') }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Qualifications</p>
                <p class="text-gray-800 font-medium">{{ $doctor->qualifications }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Years of Experience</p>
                <p class="text-gray-800 font-medium">{{ $doctor->years_of_experience }} years</p>
            </div>
        </div>
    </div>

</div>
@endsection


@php
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Doctors List';
$pageActionLink = route('doctor.list');
@endphp
