    <div class="col-span-2">

    <div class="relative flex items-center mb-4">
        <span class="absolute left-3 text-gray-400">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
       <div>
            <input
            wire:model.live="search"
                type="text"
                placeholder="Search..."
                class="pl-10 pr-4 py-2 w-64 sm:w-80 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
            >
        </div>
    </div>

        <div class="card h-full">
            <div class="card-body">
                <h4 class="text-gray-500 text-lg font-semibold mb-5">{{ $title }}</h4>
                <div class="relative overflow-x-auto">
                    <!-- table -->
                    <table class="text-left w-full whitespace-nowrap text-sm text-gray-500">
                        <thead>
                            <tr class="text-sm">
                            @foreach ($columns as $col)
                                <th scope="col" class="p-4 font-semibold">{{ $col['label'] ?? ucfirst(str_replace('_',' ', $col['path'])) }}</th>
                            @endforeach
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)                   
                                <tr>
                                    @foreach ($columns as $col)
                                      <td class="p-4">
                                            @php
                                                $value = str_contains($col['path'], '.') 
                                                    ? data_get($row, $col['path']) 
                                                    : $row->{$col['path']};

                                                // 🔍 Detect model type and assign media collection dynamically
                                                $modelType = strtolower(class_basename($row));
                                                $collection = $modelType . '-image';
                                                $imageUrl = $row->user->getFirstMediaUrl($collection);
                                            @endphp

                                            <h3 class="font-medium">
                                                {{-- 1️⃣ Dynamic image display --}}
                                                @if ($col['path'] === 'profile_image')

                                                    @if ($imageUrl)
                                                        <img src="{{ $imageUrl }}" alt="{{ $collection }} Image" class="w-12 h-12 rounded-full object-cover">
                                                    @else
                                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                                                            N/A
                                                        </div>
                                                    @endif

                                                {{-- 2️⃣ License Expiry --}}
                                                @elseif ($col['path'] === 'license_expiry_date')
                                                    @php
                                                        $isExpired = \Carbon\Carbon::parse($value)->isPast();
                                                    @endphp
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                                        {{ $isExpired ? 'bg-red-100 text-red-500' : 'bg-green-100 text-green-500' }}">
                                                        {{ $isExpired ? 'Yes' : 'No' }}
                                                    </span>

                                               @elseif ($col['path'] === 'blood_type')     
                                                    <span class="text-red-500 bg-red-100 rounded-full py-1 px-2 text-cs font-semibold">{{ $value }}</span>

                                              @elseif ($col['path'] === 'policy_number')     
                                              <span class="text-blue-600 bg-blue-100 rounded py-1 px-2 text-cs font-semibold">{{ $value }}</span>

                                                {{-- 3️⃣ Default --}}
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </h3>
                                        </td>
                                    @endforeach
                                   <td class="relative" x-data="{ open: false }">
                                        @php
                                            $modelType = strtolower(class_basename($row));
                                        @endphp

                                        <!-- 3 dots button -->
                                        <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                                            <i class="fa-solid fa-ellipsis text-gray-600"></i>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div 
                                            x-show="open" 
                                            @click.away="open = false" 
                                            x-transition 
                                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                                        >
                                            <ul class="text-sm text-gray-700">
                                                <!-- View Profile -->
                                                <li>
                                                    <a href="{{ route($modelType . '.show', $row->id) }}" 
                                                    class="block px-4 py-2 hover:bg-gray-100">
                                                    View Profile
                                                    </a>
                                                </li>

                                               @if(auth()->user()->can('manage doctors') || auth()->user()->can('manage patients'))
                                                    <li>
                                                        <a href="{{ route($modelType . '.edit', $row->id) }}" 
                                                        class="block px-4 py-2 hover:bg-gray-100">
                                                            Edit Details
                                                        </a>
                                                    </li>
                                             @endif


                                                <!-- View Schedule (Only for Doctors) -->
                                                @if ($modelType === 'doctor')
                                                    <li>
                                                        <a href="{{ route('doctor.schedule', $row->id) }}" 
                                                        class="block px-4 py-2 hover:bg-gray-100">
                                                        View Schedule
                                                        </a>
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
            {{ $data->links('vendor.livewire.tailwind') }}
        </div>

    </div>

    



