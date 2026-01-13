
@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')

<livewire:data-table model="App\Models\Doctor" 
title="Doctors List" 
:columns="[
            ['path' => 'profile_image', 'label' => 'Image'],
            ['path' => 'user.full_name', 'label' => 'Doctor'],
            ['path' => 'primarySpecialization.name', 'label' => 'Primary Specialization'],
            ['path' => 'secondarySpecialization.name', 'label' => 'Secondary Specialization'],
            ['path' => 'license_number', 'label' => 'License Number'],
            ['path' => 'license_expiry_date', 'label' => 'License Expired']
         ]"
:with="['user', 'primarySpecialization', 'secondarySpecialization']"/>

@endsection


@can('manage doctors')
    @php
        $pageActionText = '<i class="fa-solid fa-plus"></i> Add Doctor';
        $pageActionLink = route('doctor.create');
    @endphp
@endcan
