@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="card p-6">
    <h4 class="text-xl font-semibold text-gray-700 mb-6">Appointment Details</h4>

    <form action="{{ route('appointment.store') }}" method="POST" enctype="multipart/form-data">
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

        {{-- Doctor Specialization --}}
        <div class="mb-6">
            <label for="specSelect" class="block text-sm mb-2 text-gray-400">Doctor Specialization</label>
            <select id="specSelect" name="name"
                class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                <option value="">Select Doctor Specialization</option>
                @foreach ($specializations as $specialization)
                    <option value="{{ $specialization->id }}">
                        {{ $specialization->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div id="doctor-details" class="mt-8 space-y-8"></div>

        <!-- Reason for Visit -->
        <div class="mb-6 mt-5">
            <label for="reason_for_visit" class="block text-sm mb-2 text-gray-400">Reason for Visit</label>
            <textarea id="reason_for_visit" name="reason_for_visit" rows="4"
                class="w-full px-4 py-3 border border-gray-200 rounded-sm text-gray-700 text-sm focus:border-blue-600 focus:ring-0"
                placeholder="Describe the reason for your visit" required>{{ old('reason_for_visit') }}</textarea>
        </div>

        @php
            $user = auth()->user();
            $patientId = null;

            // If logged-in user is a patient
            if ($user->patient) {
                $patientId = $user->patient->id;
            }
            // If logged-in user is super admin (no patient relation)
            elseif ($user->hasRole('super-admin')) {
                // Optional: let super admin choose a patient manually later
                $patientId = null;
            }
        @endphp

        <input type="hidden" name="patient_id" value="{{ $patientId }}">
        <input type="hidden" name="doctor_id" id="doctor_id">

        <input type="hidden" name="date" id="appointment_date">
        <input type="hidden" name="day_of_week" id="appointment_day">
        <input type="hidden" name="start_time" id="appointment_start">
        <input type="hidden" name="end_time" id="appointment_end">


        <!-- Submit Button -->
        <div class="mt-8 flex justify-center">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition-all duration-200">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Save Appointment
            </button>
        </div>


    </form>
</div>
@endsection

@php
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Appointments List';
$pageActionLink = route('appointment.list');
@endphp

@section('custom-js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
    $(document).ready(function () {

        let allDoctors = [];

        $('#specSelect').change(function () {
            let selectValue = $(this).val();
            $('#doctor-details').html('');
            allDoctors = [];

            if (!selectValue) return;

            $.ajax({
                type: "GET",
                url: "{{ route('appointment.getDoctorBySpec', ':id') }}".replace(':id', selectValue),
                dataType: "json",
                success: function (response) {
                    allDoctors = response;

                    response.forEach(doctor => {
                        let imageUrl = '/default-doctor.png';
                        if (doctor.user && doctor.user.media && doctor.user.media.length > 0) {
                            imageUrl = doctor.user.media[0].original_url;
                        }

                        // Build availability days (just for info)
                        let availableDays = '';
                        if (doctor.schedules && doctor.schedules.length > 0) {
                            doctor.schedules.forEach(s => {
                                availableDays += `<span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">${s.day_of_week}</span>`;
                            });
                        } else {
                            availableDays += `<span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">No Schedules Available</span>`;
                        }

                        let doctorCard = $(`    
                            <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col gap-4 doctor-card" data-doctor-id="${doctor.id}">
                                <div class="flex items-center gap-6">
                                    <img src="${imageUrl}" alt="Doctor Image" class="w-24 h-24 rounded-full object-cover border border-gray-300">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-gray-800">Dr. ${doctor.user.full_name}</h3>
                                        <span class="bg-blue-100 text-blue-600 text-sm font-medium mt-1 inline-block px-2 py-1 rounded">
                                            ${doctor.primary_specialization.name}
                                        </span>
                                        <p class="text-gray-600 text-sm font-medium mt-5">Availability:</p>
                                        <div class="mt-3 flex flex-wrap gap-2">${availableDays}</div>
                                    </div>
                                    <button type="button" class="select-doctor bg-blue-500 text-white px-4 py-1 rounded-md text-sm">Select</button>
                                </div>
                                <div class="time-slots grid md:grid-cols-3 sm:grid-cols-2 gap-4 mt-4 hidden"></div>
                            </div>
                        `);

                        $('#doctor-details').append(doctorCard);
                    });

                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log(xhr.responseText);
                }
            });
        });


        // Handle selecting a doctor
        $(document).on('click', '.select-doctor', function () {
        $('.doctor-card').not($(this).closest('.doctor-card')).hide();
        $(this).closest('.doctor-card').find('.time-slots').removeClass('hidden');
        $(this).hide();
        $(this).after('<button type="button" class="change-doctor px-4 py-2 bg-gray-400 text-white rounded ml-2">Change Doctor</button>');

        let card = $(this).closest('.doctor-card');
        let doctorId = card.data('doctor-id');
        $('#doctor_id').val(doctorId);
        let timeContainer = card.find('.time-slots');
        timeContainer.html('');

        let doctor = allDoctors.find(d => d.id == doctorId);
        if (!doctor || !doctor.schedules) return;

        // Fetch booked slots for this doctor
        $.get("{{ route('appointment.booked', ':id') }}".replace(':id', doctorId), function(bookedSlots) {

        doctor.schedules.forEach(schedule => {
            let startTime = new Date("1970-01-01T" + schedule.start_time + "Z");
            let endTime = new Date("1970-01-01T" + schedule.end_time + "Z");
            let duration = schedule.duration;
            let slotDate = getNextDateOfDay(schedule.day_of_week);

            let slotsHtml = '';

            while (startTime < endTime) {
                let slotEndTime = new Date(startTime.getTime() + duration * 60000);
                if (slotEndTime > endTime) break;

                let slotStart = startTime.toISOString().substr(11,5);
                let slotEnd = slotEndTime.toISOString().substr(11,5);
                let slotDateTime = new Date(`${slotDate}T${slotStart}:00`);
                let isPast = slotDateTime < new Date();

                // Check if slot overlaps with booked ones
                let isReserved = bookedSlots.some(bs => {
                    if (bs.date !== slotDate) return false;

                    let slotStartNum = parseInt(slotStart.replace(':', ''), 10);
                    let slotEndNum = parseInt(slotEnd.replace(':', ''), 10);
                    let bookedStartNum = parseInt(bs.start_time.replace(':', ''), 10);
                    let bookedEndNum = parseInt(bs.end_time.replace(':', ''), 10);

                    // Check overlap (e.g., slotStart < bookedEnd && slotEnd > bookedStart)
                    return slotStartNum < bookedEndNum && slotEndNum > bookedStartNum;
                });


                let disabled = isPast || isReserved;
                let labelClasses = "px-3 py-1 rounded-full transition-colors duration-200 " + 
                                    (disabled
                                        ? (isReserved
                                            ? 'bg-red-100 text-red-600 cursor-not-allowed'
                                            : 'bg-gray-200 text-gray-400 cursor-not-allowed')
                                        : 'bg-green-100 text-green-700 hover:bg-blue-100 peer-checked:bg-blue-600 peer-checked:text-white cursor-pointer');


                let tooltip = isReserved ? 'title="This slot is already booked"' : (isPast ? 'title="Past time"' : '');

                slotsHtml += `
                    <label class="inline-block mb-2" ${tooltip}>
                        <input type="radio"
                            name="time_slot"
                            class="hidden peer"
                            required
                            data-date="${slotDate}"
                            data-day="${schedule.day_of_week}"
                            data-start="${slotStart}"
                            data-end="${slotEnd}"
                            ${disabled ? 'disabled' : ''}
                        >
                        <span class="${labelClasses}">
                            ${slotStart} - ${slotEnd}
                        </span>
                    </label>
                `;

                startTime = slotEndTime;
            }

            timeContainer.append(`
                <div class="border rounded-xl p-4 mb-4">
                    <h5 class="text-gray-700 font-medium mb-3">${schedule.day_of_week} | ${slotDate}</h5>
                    <div class="flex flex-wrap gap-2">${slotsHtml}</div>
                </div>
            `);
        });

    });
});




    $(document).on('change', 'input[name="time_slot"]', function() {
        let selected = $(this);
        $('#appointment_date').val(selected.data('date'));
        $('#appointment_day').val(selected.data('day'));
        $('#appointment_start').val(selected.data('start'));
        $('#appointment_end').val(selected.data('end'));
    });



    // Handle "Change Doctor" click
    $(document).on('click', '.change-doctor', function () {
        $('#doctor_id').val('');
        $('.doctor-card').show(); // show all doctors
        $('.time-slots').addClass('hidden').html(''); // hide all time slots
        $('.select-doctor').show(); // show all select buttons
        $(this).remove(); // remove this "Change Doctor" button
    });




    function getNextDateOfDay(dayOfWeek) {
        const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        const today = new Date();
        const todayDay = today.getDay(); // 0 (Sunday) - 6 (Saturday)
        const targetDay = days.indexOf(dayOfWeek);
        if (targetDay === -1) return null;

        let diff = targetDay - todayDay;
        if (diff < 0) diff += 7; // next week if already passed
        const nextDate = new Date(today);
        nextDate.setDate(today.getDate() + diff);
        return nextDate.toISOString().substr(0,10); // YYYY-MM-DD
    }



    });
    </script>


@endsection
