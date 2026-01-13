@extends('layouts.master')


<script src="https://cdn.tailwindcss.com"></script>

@section('content')

<div class="col-span-2">

    <div class="card h-full">
        <div class="card-body">
            <h4 class="text-gray-500 text-lg font-semibold mb-5">Roles & Permissions List</h4>
            <div class="relative overflow-x-auto">

                <table class="text-left w-full whitespace-nowrap text-sm text-gray-500">
                    <thead>
                        <tr class="text-sm">
                              <th scope="col" class="p-4 font-semibold">
                                <h6>#</h6>
                              </th>
                              <th scope="col" class="p-4 font-semibold">
                                <h6>Role Name</h6>
                              </th>
                              <th scope="col" class="p-4 font-semibold">
                                <h6>Permissions</h6>
                              </th>
                              <th scope="col" class="p-4 font-semibold">
                                <h6>Created At</h6>
                              </th>
                              <th scope="col" class="p-4 font-semibold">
                                <h6>Actions</h6>
                              </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                               <td class="p-4">{{ $role->id }}</td>
                               <td class="p-4">{{ $role->name }}</td>

                               <td>
                               @foreach ($role->permissions->take(3) as $permission)
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-600 inline-block mb-1">
                                        {{ $permission->name }}
                                    </span>
                               @endforeach

                               @if($role->permissions->count() > 3)
                               <button class="px-3 py-1 rounded-full text-sm font-medium bg-purple-200 text-purple-600 inline-block mb-1">
                                      +{{ $role->permissions->count() - 3 }} more
                                  </button>
                              @endif
                               </td>

                               <td class="p-4">{{ $role->created_at->format('d M y') }}</td>

                              <td class="p-4">
                                    <!-- Edit -->
                                    <a href="{{ route('role.edit', $role->id) }}" 
                                    class="inline-flex items-center justify-center px-2 py-1 text-blue-600 hover:text-blue-800 transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form onsubmit="confirmation(event)" action="{{ route('role.delete', $role->id) }}" method="POST" class="inline-flex items-center justify-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center px-2 py-1 text-red-600 hover:text-red-800 transition">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                            </td>

                            </tr>
                            @empty
                            <tr>
                                <td class="text-center text-gray-500 py-4 font-semibold text-lg" colspan="12">No Roles Yet</td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $roles->links('vendor.livewire.tailwind') }}
    </div>
</div>

@endsection


@php
$pageActionText = '<i class="fa-solid fa-plus"></i> Create Role';
$pageActionLink = route('role.create');
@endphp