@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="card bg-white shadow-sm rounded-2xl p-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <h4 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="fa-regular fa-calendar-plus text-blue-600"></i>
            Create Doctor <span class="text-[#9B8FFA]">{{ $doctor->user->full_name }}'s</span> Schedule
        </h4>
        <a href="{{ route('doctor.schedule', $doctor->id) }}" 
           class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-150">
           <i class="fa-solid fa-arrow-left"></i> Back to Schedules
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('doctor.schedule.store') }}" method="POST" class="bg-gradient-to-r from-blue-50 to-indigo-50 p-8 rounded-xl border border-blue-100">
        @csrf

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-300 text-red-700">
                <h4 class="font-semibold text-red-800 mb-2">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Please fix the following errors:
                </h4>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

            <!-- Day of Week -->
            <div>
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-2">
                        Days of Week
                    </label>
                    <div class="flex items-center gap-2">
                        <select id="day_of_week" name="day_of_week[]" 
                                class="select2 w-full rounded-lg border-gray-200 focus:border-blue-600 focus:ring-0 text-gray-700 py-3 px-4" multiple>
                            @php
                                $daysOfWeek = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                            @endphp

                            @foreach($daysOfWeek as $day)
                                @if(!in_array($day, $existingDays))
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endif
                            @endforeach
                      </select>


                        <button type="button" id="select-all-days"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium shadow-sm transition-all duration-150">
                            Select All
                        </button>
                    </div>
            </div>


            <!-- Duration -->
            <div>
                <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                    Duration (Minutes)
                </label>
                <input type="number" min="15" step="any" id="duration" name="duration" placeholder="e.g., 30"
                       class="w-full rounded-lg border-gray-200 focus:border-blue-600 focus:ring-0 text-gray-700 py-3 px-4">
            </div>

            <!-- Start Time -->
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                    Start Time
                </label>
                <input type="time" id="start_time" name="start_time"
                       class="w-full rounded-lg border-gray-200 focus:border-blue-600 focus:ring-0 text-gray-700 py-3 px-4">
            </div>

            <!-- End Time -->
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                    End Time
                </label>
                <input type="time" id="end_time" name="end_time"
                       class="w-full rounded-lg border-gray-200 focus:border-blue-600 focus:ring-0 text-gray-700 py-3 px-4">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <select id="is_available" name="is_available"
                        class="w-full rounded-lg border-gray-200 focus:border-blue-600 focus:ring-0 text-gray-700 py-3 px-4">
                    <option value="">Select Status</option>
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
                </select>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="mt-8 flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition-all duration-200">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Save Schedule
            </button>
        </div>
    </form>

</div>
@endsection



@php
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Doctor Schedule';
$pageActionLink = route('doctor.schedule', $doctor->id);
@endphp




@section('custom-js')
<script>
$(document).ready(function () {
    const $select = $('#day_of_week');

    $select.select2({
        placeholder: 'Select Day(s)',
        allowClear: true,
        width: '100%'
    });

    // Select all button
    $('#select-all-days').click(function() {
        const allValues = $select.find('option').map(function() {
            return $(this).val();
        }).get();

        // If all are selected → clear all instead
        if ($select.val()?.length === allValues.length) {
            $select.val(null).trigger('change');
            $(this).text('Select All');
        } else {
            $select.val(allValues).trigger('change');
            $(this).text('Clear All');
        }
    });
});
</script>
@endsection

