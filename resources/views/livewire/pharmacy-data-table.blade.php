<div class="col-span-2">

    <!-- Search -->
    <div class="relative flex items-center mb-4 gap-4">
        <span class="absolute left-3 text-gray-400">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input
            wire:model.live="search"
            type="text"
            placeholder="Search..."
            class="pl-10 pr-4 py-2 w-64 sm:w-80 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
        >

        <div>
            <select wire:model.live="category" class="py-2 px-2 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->value }}">{{ $category->value }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <select wire:model.live="status" class="py-2 px-2 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                <option value="">Select Status</option>
                <option value="in_stock">In Stock</option>
                <option value="low_stock">Low Stock</option>    
                <option value="out_of_stock">Out of Stock</option>
            </select>
      </div>


    </div>

    <div class="card h-full">
        <div class="card-body">
            <h4 class="text-gray-500 text-lg font-semibold mb-5">Medicine List</h4>
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
                        @forelse ($medicines as $medicine)
                            <tr>
                                @foreach ($columns as $col)
                                    <td class="p-4">
                                        @php $path = $col['path']; @endphp

                                        @switch($path)

                                            {{-- ID --}}
                                            @case('id')
                                              {{ $medicine->id }}
                                            @break

                                            {{-- Medicine Name --}}
                                            @case('medicine_name')
                                                {{ $medicine->medicine_name }}
                                            @break

                                            @case('generic_name')
                                            {{ $medicine->generic_name  }}
                                            @break

                                            {{-- Category --}}
                                           @case('category')
                                            {{ $medicine->category  }}
                                            @break

                                            {{-- Stock --}}
                                           @case('stock')
                                           <span class="{{ $medicine->quantity > 0 ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600' }} px-3 py-1 rounded-full text-sm font-medium">{{ $medicine->quantity  }} units</span>
                                            @break

                                            {{-- Expiry Date --}}
                                           @case('expiry_date')
                                            {{ $medicine->expiry_date->format('d M y')  }}
                                            @break

                                            @case('reorder_level')
                                                <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-sm font-medium">{{ $medicine->reorder_level ?? 'NAN' }}</span>
                                            @break

                                           @case('status')
                                                @php
                                                    $reorderLevel = (int) ($medicine->reorder_level ?? 0);
                                                    $quantity = (int) ($medicine->quantity ?? 0);

                                                    if ($quantity <= 0) {
                                                        $statusText = 'Out of Stock';
                                                        $statusClass = 'bg-red-100 text-red-600';
                                                    } elseif ($quantity <= $reorderLevel) {
                                                        $statusText = 'Low Stock';
                                                        $statusClass = 'bg-yellow-100 text-yellow-600';
                                                    } else {
                                                        $statusText = 'In Stock';
                                                        $statusClass = 'bg-green-100 text-green-600';
                                                    }
                                                @endphp

                                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                                                    {{ $statusText }}
                                                </span>
                                            @break


                                            {{-- Default fallback --}}
                                            @default
                                                {{ data_get($medicine, $path) }}
                                        @endswitch
                                    </td>
                                @endforeach

                                <td class="p-4 w-12 text-center">
                                    <a href="{{ route('pharmacy.show', $medicine->id) }}" 
                                        class="px-2 py-1 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td class="text-center text-gray-500 py-4 font-semibold text-lg" colspan="12">No Medicines Yet</td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $medicines->links('vendor.livewire.tailwind') }}
    </div>
</div>