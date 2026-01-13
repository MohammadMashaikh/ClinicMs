@extends('layouts.master')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <!-- table 1 -->
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        <!-- CREATE FORM START -->
        <form class="p-6" action="{{ route('users.store') }}" method="POST">
          @csrf
          <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100">Create User</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- First Name -->
            <div>
              <label for="firstName" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
              <input type="text" id="firstName" name="firstName" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>

            <!-- Second Name -->
            <div>
              <label for="secondName" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Second Name</label>
              <input type="text" id="secondName" name="secondName" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
              <input type="email" id="email" name="email" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
              <input type="password" id="password" name="password" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>

            <!-- Confirm Password -->
            <div>
              <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>

            <!-- Phone -->
            <div>
              <label for="phone" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
              <input type="tel" id="phone" name="phone"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>

            <!-- Role Dropdown -->
            <div>
              <label for="role" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
              <select id="role" name="role" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                <option value="" disabled selected>Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
              </select>
            </div>

            <!-- Gender Dropdown -->
            <div>
              <label for="gender" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
              <select id="gender" name="gender" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mt-6 flex justify-center">
            <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
              Create User
            </button>
          </div>
        </form>
        <!-- CREATE FORM END -->

      </div>
    </div>
  </div>
</div>


@endsection
