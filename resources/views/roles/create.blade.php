@extends('layouts.master')

<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <!-- Page Title -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-1">Create New Role</h2>
        <p class="text-gray-500 text-sm">Add a new role and assign permissions below.</p>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
        <form action="{{ route('role.store') }}" method="POST">
            @csrf

            <!-- Role Name -->
            <div class="mb-6">
                <label for="role_name" class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                <input type="text" name="name" id="role_name" value="{{ old('name') }}"
                    class="w-full rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2 px-3 text-sm"
                    placeholder="Enter role name" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Permissions Section -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-700 mb-3">Assign Permissions</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($permissions as $permission)
                        <label class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">{{ ucfirst($permission->name) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('role.list') }}"
                    class="px-4 py-2 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                    Create Role
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
