@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>


@section('content')

<livewire:appointment-data-table
:columns="[
            ['path' => 'patient_image', 'label' => 'Patient'],
            ['path' => 'user.full_name', 'label' => 'Doctor'],
            ['path' => 'date', 'label' => 'Date'],
            ['path' => 'day_of_week', 'label' => 'Day'],
            ['path' => 'time', 'label' => 'Start & End Time'],
            ['path' => 'status', 'label' => 'Status'],
         ]"
>

@endsection


@php
    $pageActionText = '<i class="fa-solid fa-plus"></i> Add Appointment';
    $pageActionLink = route('appointment.create');
@endphp