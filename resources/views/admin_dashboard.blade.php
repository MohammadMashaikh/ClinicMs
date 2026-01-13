


<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="p-6 space-y-6">

    <!-- 4 Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fa-solid fa-calendar-check fa-lg"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Appointments</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalAppointments }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fa-solid fa-user-injured fa-lg"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Patients</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalPatients }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fa-solid fa-user-doctor fa-lg"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Staff</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalStaff }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fa-solid fa-dollar-sign fa-lg"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-800">$50,000</p>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-gray-500 font-semibold mb-4">Users by Role</h3>
            <canvas id="usersRoleChart"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-gray-500 font-semibold mb-4">Medicines Stock Status</h3>
            <canvas id="stockChart"></canvas>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="bg-white shadow rounded-xl p-6 mt-6">
        <h3 class="text-gray-500 font-semibold mb-4">Recent Appointments</h3>
		<p class="text-gray-500 mb-5">There is <span class="text-blue-600">{{ $todayAppointments }}</span> appointments today.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Appointment Card Example -->
            @foreach($recentAppointments as $appointment)
            <div class="bg-gray-50 rounded-xl p-4 flex flex-col gap-2 shadow">
                <div class="flex items-center gap-3">
                    <img src="{{ $appointment->patient->user->getFirstMediaUrl('patient-image') }}" alt="Patient Image" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $appointment->patient->user->full_name }}</p>
                        <p class="text-gray-500 text-sm">{{ $appointment->reason_for_visit }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center text-gray-500 text-sm mt-2">
                    <p>{{ $appointment->date->format('d M Y') }} | {{ $appointment->start_time->format('H:i A') }}</p>
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        	@switch($appointment->status)
							@case('Completed')
							bg-green-100 text-green-600
							@break

							@case('Pending')
							bg-yellow-100 text-yellow-600
							@break

							@case('Confirmed')
							bg-blue-100 text-blue-600
							@break

							@case('In Progress')
							bg-amber-200 text-amber-700
							@break
							@default
							bg-red-100 text-red-600
							@endswitch ">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

		<div class="px-2 py-1 rounded-full text-lg font-medium bg-blue-200 text-blue-600 text-center mt-5 w-1/2 mx-auto">
			<a href="{{ route('appointment.list') }}">View All Appointments</a>
		</div>

    </div>
</div>

<script>
    // Users by Role Chart
	const totalPatients = @json($totalPatients);
	const totalDoctors = @json($totalDoctors);
	const totalPharmacy = @json($totalPharmacy);
	const totalReceptionist = @json($totalReceptionist);
	
	const inStock = @json($inStock);
	const lowStock = @json($lowStock);
	const outOfStock = @json($outOfStock);
	
    const usersRoleCtx = document.getElementById('usersRoleChart').getContext('2d');
    new Chart(usersRoleCtx, {
        type: 'doughnut',
        data: {
            labels: ['Doctors', 'Patients', 'Pharmacies', 'Receptionist'],
            datasets: [{ data: [totalDoctors, totalPatients, totalPharmacy, totalReceptionist], backgroundColor: ['#3b82f6','#10b981','#ef4444','#f59e0b'] }]
        }
    });

    // Medicines Stock Chart
    const stockCtx = document.getElementById('stockChart').getContext('2d');
    new Chart(stockCtx, {
        type: 'bar',
        data: {
            labels: ['In Stock', 'Low Stock', 'Out of Stock'],
            datasets: [{ label: 'Medicines', data: [inStock, lowStock, outOfStock], backgroundColor: ['#10b981','#fbbf24','#ef4444'] }]
        },
        options: { scales: { y: { beginAtZero:true } } }
    });
</script>


@php
    $pageActionText = '<i class="fa-solid fa-flag"></i> Generate Report';
    $pageActionLink = route('doctor.create');
@endphp
