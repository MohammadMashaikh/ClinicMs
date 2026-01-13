<script src="https://cdn.tailwindcss.com"></script>

<div class="p-8 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Doctor Dashboard</h2>
        <p class="text-gray-500 text-sm">Welcome back, Dr. <span class="text-purple-600">{{ auth()->user()->full_name  }}</span></p>
    </div>

    <!-- 4 Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Appointments -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Appointments</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $doctorTotalAppointments }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fa-solid fa-calendar-check text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending Appointments</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $doctorPendingAppointments }}</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="fa-solid fa-hourglass-half text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Patients -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Patients</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $doctorTotalAppointments }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fa-solid fa-user-injured text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Monthly Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">$5,320</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <i class="fa-solid fa-coins text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule & Upcoming -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Today's Schedule -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-calendar-day text-blue-500"></i>
                Today's Schedule
            </h4>

            @foreach ($doctorTodaySchedule as $appointment)
                
                @php
                    // Get the matching schedule for this appointment's day
                    $schedule = $appointment->doctor->schedules
                        ->where('day_of_week', $appointment->day_of_week)
                        ->first();

                    $duration = $schedule ? $schedule->duration : 'N/A';
                @endphp


            <div class="grid gap-4">
                <!-- Appointment Card -->
                <div class="border rounded-xl p-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ $appointment->patient->user->getFirstMediaUrl('patient-image') }}" class="w-14 h-14 rounded-full object-cover border border-gray-300" alt="Patient">
                        <div>
                            <h5 class="text-gray-800 font-semibold">{{ $appointment->patient->user->full_name }}</h5>
                            <p class="text-gray-500 text-sm"><i class="fa-regular fa-calendar"></i> Day: {{ $appointment->day_of_week }}</p>
                            <p class="text-gray-500 text-sm">
                                <i class="fa-regular fa-alarm-clock"></i>
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <p class="text-gray-600 text-sm mb-2">Duration: {{ $duration }} mins</p>
                        <div class="flex gap-2">
                            <a href="{{ route('appointment.show', $appointment->id) }}" class="px-4 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                <i class="fa-solid fa-eye mr-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            @endforeach
        </div>

        <!-- Upcoming Appointments -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-calendar-week text-green-500"></i>
                Upcoming Appointments
            </h4>

           @foreach ($doctorUpComingSchedule as $upComingAppointment)
                @php
                    $appointmentDate = \Carbon\Carbon::parse($upComingAppointment->date);
                    $today = \Carbon\Carbon::today();
                    $tomorrow = $today->copy()->addDay();

                    // If the appointment is tomorrow, display "Tomorrow", else show formatted date
                    if ($appointmentDate->isSameDay($tomorrow)) {
                        $formattedDate = 'Tomorrow';
                    } else {
                        $formattedDate = $appointmentDate->format('D • M d, Y');
                    }

                    $startTime = \Carbon\Carbon::parse($upComingAppointment->start_time)->format('h:i A');
                    $endTime = \Carbon\Carbon::parse($upComingAppointment->end_time)->format('h:i A');

                    // Set badge color dynamically
                    $status = $upComingAppointment->status;
                    $statusColors = [
                        'Pending' => 'bg-yellow-100 text-yellow-600',
                        'Confirmed' => 'bg-green-100 text-green-600',
                        'In Progress' => 'bg-blue-100 text-blue-600',
                        'Completed' => 'bg-gray-100 text-gray-600',
                        'Cancelled' => 'bg-red-100 text-red-600',
                    ];
                    $statusClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-600';
                @endphp

                <div class="border rounded-xl p-4 flex items-center justify-between hover:bg-gray-50 transition mb-3">
                    <div>
                        <h5 class="text-gray-800 font-semibold">
                            {{ $upComingAppointment->patient->user->full_name }}
                        </h5>
                        <p class="text-gray-500 text-sm">
                            {{ $formattedDate }} • {{ $startTime }} - {{ $endTime }}
                        </p>
                        <p class="text-gray-400 text-sm">
                            {{ $upComingAppointment->reason_for_visit ?? 'No reason provided' }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                        {{ $status }}
                    </span>
                </div>
            @endforeach

        </div>
    </div>




    <div class="card p-8 bg-white shadow-sm rounded-2xl mt-10">
    
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
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($doctorSchedule->schedules as $schedule)
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



</div>

