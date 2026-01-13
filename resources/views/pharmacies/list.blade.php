@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')

<livewire:pharmacy-data-table
    :columns="[
        ['path' => 'id', 'label' => 'ID'],
        ['path' => 'medicine_name', 'label' => 'Medicine Name'],
        ['path' => 'generic_name', 'label' => 'Generic Name'],
        ['path' => 'category', 'label' => 'Category'],
        ['path' => 'stock', 'label' => 'Stock'],
        ['path' => 'expiry_date', 'label' => 'Expiry Date'],
        ['path' => 'reorder_level', 'label' => 'Re-Order Level'],
        ['path' => 'status', 'label' => 'Status'],
    ]"
/>

@endsection



@php
    $pageActionText = '<i class="fa-solid fa-share-from-square"></i> Medicines List';
    $pageActionLink = route('pharmacy.list');
@endphp