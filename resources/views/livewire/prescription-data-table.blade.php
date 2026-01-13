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
                            <th scope="col" class="p-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescriptions as $prescription)
                            <tr>
                                @foreach ($columns as $col)
                                    <td class="p-4">
                                        @php $path = $col['path']; @endphp

                                        @switch($path)

                                            {{-- Patient Image + Name --}}
                                            @case('patient_image')
                                                @php
                                                    $patientUser = $prescription->patient->user ?? null;
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
                                                    $doctorUser = $prescription->doctor->user ?? null;
                                                    $fullName = $doctorUser ? $doctorUser->full_name : 'N/A';
                                                @endphp
                                                {{ $fullName }}
                                            @break

                                            @case('date')
                                            {{ $prescription->created_at->format('d M y') }}
                                            @break

                                            {{-- Medications --}}
                                                @case('medications')
                                                    <div class="flex gap-1">
                                                        @foreach($prescription->items as $item)
                                                            <button 
                                                                onclick="Swal.fire({
                                                                    title: '{{ addslashes($item->medication_name) }}',
                                                                    html: `
                                                                        <p><strong>Dosage:</strong> {{ addslashes($item->dosage) }}</p>
                                                                        <p><strong>Frequency:</strong> {{ addslashes($item->frequency) }}</p>
                                                                        <p><strong>Duration:</strong> {{ addslashes($item->duration) }}</p>
                                                                        <p><strong>Instructions:</strong> {{ addslashes($item->instructions ?: 'No instructions') }}</p>
                                                                    `,
                                                                    icon: 'info',
                                                                    showCloseButton: true,
                                                                })"
                                                                class="text-left px-3 py-2 bg-blue-100 hover:bg-blue-300 rounded shadow text-sm font-medium transition-all duration-150">
                                                                {{ $item->medicine_name }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                @break

                                            {{-- Default fallback --}}
                                            @default
                                                {{ data_get($prescription, $path) }}
                                        @endswitch
                                    </td>
                                @endforeach

                                <td class="p-4 w-12 text-center">
                                    <a href="{{ route('prescription.show', $prescription->id) }}" 
                                        class="px-2 py-1 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $prescriptions->links('vendor.livewire.tailwind') }}
    </div>
</div>