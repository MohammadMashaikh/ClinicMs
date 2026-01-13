@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="card p-8 bg-white shadow-sm rounded-2xl">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <h4 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-doctor text-blue-600"></i>
            Doctor’s Schedule
        </h4>
        <div class="flex justify-between gap-4">
        <a href="{{ route('doctor.list') }}" 
           class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-150">
           <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
        @can('manage schedule')
        <a href="{{ route('doctor.schedule.create', $doctor->id) }}" 
           class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-150">
           <i class="fa-solid fa-plus"></i> Add Schedule
        </a>
        @endcan
        </div>
    </div>

    <!-- Doctor Info Card -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100 mb-8">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-200 shadow-md">
                <img src="{{ $doctor->user->getFirstMediaUrl('doctor-image') }}" 
                     alt="Doctor Profile" class="w-full h-full object-cover">
            </div>
            <div>
                <h5 class="text-xl font-semibold text-gray-800">Dr {{ $doctor->user->full_name }}</h5>
                <p class="text-gray-600 text-sm">{{ $doctor->primarySpecialization->name }} • {{ $doctor->years_of_experience }} {{ $doctor->years_of_experience > 1 ? 'Years' : 'Year'}} Experience</p>
                <p class="text-gray-500 text-sm mt-1"><i class="fa-solid fa-location-dot text-blue-500 mr-1"></i>{{ $doctor->user->address }}</p>
            </div>
        </div>
    </div>

    <!-- Schedule Section -->
    <div class="mb-10">
        <h5 class="text-lg font-semibold text-gray-700 mb-5 flex items-center gap-2">
            <i class="fa-regular fa-calendar-days text-blue-600"></i>
            Weekly Availability
        </h5>

        <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium">Day</th>
                        <th class="py-3 px-4 text-left font-medium">Start Time</th>
                        <th class="py-3 px-4 text-left font-medium">End Time</th>
                        <th class="py-3 px-4 text-left font-medium">Duration</th>
                        <th class="py-3 px-4 text-left font-medium">Status</th>
                        @can('manage doctors')
                        <th class="py-3 px-4 text-left font-medium">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($doctor->schedules as $schedule)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="py-3 px-4 font-medium">{{ $schedule->day_of_week }}</td>
                        <td class="py-3 px-4">{{ $schedule->start_time }}</td>
                        <td class="py-3 px-4">{{ $schedule->end_time }}</td>
                        <td class="py-3 px-4">{{ $schedule->duration }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 {{ $schedule->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full text-xs font-medium">
                                {{ $schedule->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </td>
                        @can('manage doctors')
                        <td class="pt-3 px-4 flex justify-center">
                            <a href="{{ route('doctor.schedule.edit', $schedule->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form onsubmit="confirmation(event)" action="{{ route('doctor.schedule.delete', $schedule->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                               <button type="submit"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notes / Footer -->
    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
        <p class="text-sm text-gray-500">
            <i class="fa-solid fa-info-circle text-blue-500 mr-1"></i>
            The schedule above shows the doctor’s available hours. Please contact the clinic for urgent appointments.
        </p>
    </div>
</div>
@endsection

@php
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Doctors List';
$pageActionLink = route('doctor.list');
@endphp
