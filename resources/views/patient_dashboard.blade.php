<script src="https://cdn.tailwindcss.com"></script>

<div class="p-8 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Patient Dashboard</h2>
        <p class="text-gray-500 text-sm">Welcome back, <span class="text-blue-600">{{ auth()->user()->full_name }}</span></p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <!-- Total Appointments -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Appointments</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $patientTotalAppointments }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fa-solid fa-calendar-check text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Upcoming -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Upcoming Appointments</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $patientUpcomingAppointments }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fa-solid fa-calendar-day text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Completed Appointments</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $patientCompletedAppointments }}</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <i class="fa-solid fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Cancelled -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Cancelled Appointments</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $patientCancelledAppointments }}</h3>
                </div>
                <div class="bg-red-100 text-red-600 p-3 rounded-full">
                    <i class="fa-solid fa-times-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Upcoming Appointments -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-calendar-week text-green-500"></i>
                Upcoming Appointments
            </h4>

            @forelse ($patientUpcoming as $appointment)
                <div class="border rounded-xl p-4 flex items-center justify-between hover:bg-gray-50 transition mb-3">
                    <div>
                        <h5 class="text-gray-800 font-semibold">
                            {{ $appointment->doctor->user->full_name }}
                        </h5>
                        <p class="text-gray-500 text-sm">
                            {{ \Carbon\Carbon::parse($appointment->date)->format('D • M d, Y') }}
                            • {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                            - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                        </p>
                        <p class="text-gray-400 text-sm">
                            {{ $appointment->reason_for_visit ?? 'No reason provided' }}
                        </p>
                    </div>
                    <a href="{{ route('appointment.show', $appointment->id) }}" class="px-4 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                        <i class="fa-solid fa-eye mr-1"></i> View
                    </a>
                </div>
            @empty
                <p class="text-gray-400 text-sm">No upcoming appointments.</p>
            @endforelse
        </div>

        <!-- Appointment History -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-blue-500"></i>
                Appointment History
            </h4>

            @forelse ($patientHistory as $past)

                @php
                 $statusClasses = '';
                 
                 switch ($past->status) {
                    case 'Confirmed':
                        $statusClasses = 'bg-blue-100 text-blue-700';
                        break;

                    case 'Completed':
                        $statusClasses = 'bg-green-100 text-green-700';
                        break;

                    case 'Pending':
                        $statusClasses = 'bg-yellow-100 text-yellow-700';
                        break;

                    case 'In Progress':
                        $statusClasses = 'bg-amber-100 text-amber-700';
                        break;

                    case 'Cancelled':
                        $statusClasses = 'bg-red-100 text-red-700';
                        break;
                    
                    default:
                        $statusClasses = 'bg-gray-100 text-gray-700';
                        break;
                 }
                @endphp
                <div class="border rounded-xl p-4 hover:bg-gray-50 transition mb-3">
                    <h5 class="text-gray-800 font-semibold">{{ $past->doctor->user->full_name }}</h5>
                    <p class="text-gray-500 text-sm">
                        {{ \Carbon\Carbon::parse($past->date)->format('D • M d, Y') }}
                        • {{ \Carbon\Carbon::parse($past->start_time)->format('h:i A') }}
                        - {{ \Carbon\Carbon::parse($past->end_time)->format('h:i A') }}
                    </p>
                    <p class="text-gray-400 text-sm mb-2">
                        {{ $past->reason_for_visit ?? 'No reason provided' }}
                    </p>
                    <span class="px-3 py-1 text-sm rounded-full 
                        {{ $statusClasses }}">
                        {{ $past->status }}
                    </span>
                </div>
            @empty
                <p class="text-gray-400 text-sm">No past appointments.</p>
            @endforelse
        </div>
    </div>

    <!-- Assigned Doctor -->
    <div class="bg-white p-6 rounded-2xl shadow mt-10">
        <h4 class="text-lg font-semibold text-gray-700 mb-5 flex items-center gap-2">
            <i class="fa-solid fa-user-md text-purple-600"></i>
            Assigned Doctor
        </h4>

        @if ($patientDoctor)
            <div class="flex items-center gap-5">
                <img src="{{ $patientDoctor->user->getFirstMediaUrl('doctor-image') }}" class="w-16 h-16 rounded-full object-cover border border-gray-300" alt="Doctor">
                <div>
                    <h5 class="text-gray-800 font-semibold mb-4"><a href="{{ route('doctor.show', $patientDoctor->id) }}">{{ $patientDoctor->user->full_name }}</a></h5>
                    <span class="px-3 py-1 text-sm rounded-full bg-pink-100 text-pink-700">{{ $patientDoctor->primarySpecialization->name }}</span>
                    <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-700">{{ $patientDoctor->user->email }}</span>
                </div>
            </div>
        @else
            <p class="text-gray-400 text-sm">No assigned doctor yet.</p>
        @endif
    </div>

</div>
