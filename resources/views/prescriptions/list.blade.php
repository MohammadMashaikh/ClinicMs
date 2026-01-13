@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')

<livewire:prescription-data-table
    :columns="[
        ['path' => 'patient_image', 'label' => 'Patient'],
        ['path' => 'doctor.user.full_name', 'label' => 'Doctor'],
        ['path' => 'date', 'label' => 'Date'],
        ['path' => 'medications', 'label' => 'Medications'],
    ]"
/>

@endsection



@php
    $pageActionText = '<i class="fa-solid fa-share-from-square"></i> Prescriptions List';
    $pageActionLink = route('prescription.list');
@endphp