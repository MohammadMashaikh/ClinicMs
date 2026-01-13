<div class="col-span-2">

    <!-- Search -->
    <div class="relative flex items-center mb-4">
        <span class="absolute left-3 text-gray-400">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input
            wire:model.live="search"
            type="text"
            placeholder="Search..."
            class="pl-10 pr-4 py-2 w-64 sm:w-80 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
        >
    </div>

    <div class="card h-full">
        <div class="card-body">
            <h4 class="text-gray-500 text-lg font-semibold mb-5">Prescriptions List</h4>
            <div class="relative overflow-x-auto">

                <table class="text-left w-full whitespace-nowrap text-sm text-gray-500">
                    <thead>
                        <tr class="text-sm">
                            @foreach ($columns as $col)
                                <th scope="col" class="p-4 font-semibold">
                                    {{ $col['label'] ?? ucfirst(str_replace('_',' ', $col['path'])) }}
                                </th>
                            @endforeach
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                @foreach ($columns as $col)
                                    <td class="p-4">
                                        @php
                                            $path = $col['path'];
                                        @endphp

                                        @switch($path)

                                            {{-- Patient Image + Name --}}
                                            @case('patient_image')
                                                @php
                                                    $patientUser = $appointment->patient->user;
                                                    $imageUrl = $patientUser ? $patientUser->getFirstMediaUrl('patient-image') : null;
                                                    $fullName = $patientUser ? $patientUser->full_name : 'N/A';
                                                @endphp
                                                <div class="flex items-center gap-3">
                                                    @if($imageUrl)
                                                        <img src="{{ $imageUrl }}" alt="Patient Image" class="w-12 h-12 rounded-full object-cover">
                                                    @else
                                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                                                            N/A
                                                        </div>
                                                    @endif
                                                    <span>{{ $fullName }}</span>
                                                </div>
                                            @break

                                            {{-- Doctor Full Name --}}
                                            @case('user.full_name')
                                                @php
                                                    $doctorUser = $appointment->doctor->user ?? null;
                                                    $fullName = $doctorUser ? $doctorUser->full_name : 'N/A';
                                                @endphp
                                                {{ $fullName }}
                                            @break

                                            @case('date')
                                            {{ $appointment->date->format('d M y') }}
                                            @break  

                                            @case('day_of_week')
                                            {{ $appointment->day_of_week }}
                                            @break

                                            {{-- Start and End Tiem --}}
                                            @case('time')
                                                
                                             <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                {{ $appointment->start_time->format('H:i A') }} - {{ $appointment->end_time->format('H:i A') }}
                                             </span>
                                            @break

                                            {{-- Status --}}
                                           @case('status')
                                            @php
                                                $statusClasses = [
                                                    'confirmed'   => 'bg-blue-100 text-blue-600',
                                                    'pending'     => 'bg-yellow-100 text-yellow-600',
                                                    'in progress' => 'bg-orange-100 text-orange-400',
                                                    'cancelled'   => 'bg-red-100 text-red-600',
                                                    'completed'      => 'bg-green-100 text-green-600',
                                                ];

                                                $status = strtolower($appointment->status);
                                                $badgeClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-600';
                                            @endphp

                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        @break


                                            {{-- Default fallback --}}
                                            @default
                                                {{ data_get($appointment, $path) }}
                                        @endswitch
                                    </td>
                                @endforeach

                                {{-- Actions --}}
                                <td class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                                        <i class="fa-solid fa-ellipsis text-gray-600"></i>
                                    </button>
                                    <div 
                                        x-show="open" 
                                        @click.away="open = false" 
                                        x-transition 
                                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                                    >

                                   @php
                                    $showConfirm = false;
                                    $showProgress = false;
                                    $showCancelled = false;

                                    switch (strtolower($appointment->status)) {
                                        case 'pending':
                                            $showConfirm = true;
                                            $showCancelled = true;
                                            break;

                                        case 'confirmed':
                                            $showProgress = true;
                                            $showCancelled = true;
                                            break;

                                        case 'in progress':
                                        case 'cancelled':
                                        case 'completed':
                                            // all false
                                            break;
                                    }
                                @endphp



                                        <ul class="text-sm divide-y divide-gray-100">

                                            <li class="text-gray-700">
                                                <a href="{{ route('appointment.show', $appointment->id) }}"
                                                class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                                                    <i class="fa-solid fa-eye"></i> View Details
                                                </a>
                                            </li>


                                            @if (auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super-admin'))
                                                @if ($showConfirm)
                                                    <li class="text-green-700">
                                                        <form onsubmit="confirmAppointment(event)" 
                                                            action="{{ route('appointment.confirm', $appointment->id) }}" 
                                                            method="POST"
                                                            class="m-0 p-0">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                                                                <i class="fa-solid fa-check-double"></i> Confirm Appointment
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                                @if ($showProgress)
                                                    <li class="text-yellow-700">
                                                        <form onsubmit="progressAppointment(event)" 
                                                            action="{{ route('appointment.progress', $appointment->id) }}" 
                                                            method="POST"
                                                            class="m-0 p-0">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                                                                <i class="fa-solid fa-check"></i> Mark as In Progress
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            @endif

                                            @if ((auth()->user()->hasRole('patient') || auth()->user()->hasRole('super-admin')) && $showCancelled)
                                                <li class="text-red-700">
                                                    <form onsubmit="cancelAppointment(event)" 
                                                        action="{{ route('appointment.cancel', $appointment->id) }}" 
                                                        method="POST"
                                                        class="m-0 p-0">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
                                                            <i class="fa-solid fa-xmark"></i> Cancel Appointment
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>


                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $appointments->links('vendor.livewire.tailwind') }}
    </div>
</div>
