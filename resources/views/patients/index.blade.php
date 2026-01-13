
@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<livewire:data-table model="App\Models\Patient" 
title="Patients List" 
:columns="[
            ['path' => 'profile_image', 'label' => 'Image'],
            ['path' => 'user.full_name', 'label' => 'Patient'],
            ['path' => 'blood_type', 'label' => 'Blood Type'],
            ['path' => 'height', 'label' => 'Height'],
            ['path' => 'height', 'label' => 'Weight'],
            ['path' => 'insurance_provider', 'label' => 'Insurance Provider'],
            ['path' => 'policy_number', 'label' => 'Policy Number'],
         ]"
:with="['user']"/>

@endsection

@can('manage doctors')
@php
    $pageActionText = '<i class="fa-solid fa-plus"></i> Add Patient';
    $pageActionLink = route('patient.create');
@endphp
@endcan