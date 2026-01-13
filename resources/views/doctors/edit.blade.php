@extends('layouts.master')


<script src="https://cdn.tailwindcss.com"></script>


@section('content')
<div class="card p-6">
    <h4 class="text-xl font-semibold text-gray-700 mb-6">Doctor Profile</h4>

    <form action="{{ route('doctor.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-300 text-red-700">
                <h4 class="font-semibold text-red-800 mb-2">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Please fix the following errors:
                </h4>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- Top Section: Personal Info + Profile Image --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            {{-- LEFT: Personal Information --}}
            <div class="md:col-span-2">
                <h5 class="text-lg font-medium text-gray-600 mb-4">Personal Information</h5>
                <div class="card-body">
                    <div class="mb-6">
                        <label for="first_name" class="block text-sm mb-2 text-gray-400">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $doctor->user->first_name) }}"
                               class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="last_name" class="block text-sm mb-2 text-gray-400">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $doctor->user->last_name) }}"
                               class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="date_of_birth" class="block text-sm mb-2 text-gray-400">Date Of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" 
                               value="{{ old('date_of_birth', $doctor->user->date_of_birth->format('Y-m-d')) }}"
                               class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="gender" class="block text-sm mb-2 text-gray-400">Gender</label>
                        <select id="gender" name="gender" class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Gender</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender->value }}" {{ old('gender', $doctor->user->gender->value) == $gender->value ? 'selected' : '' }}>
                                    {{ $gender->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="address" class="block text-sm mb-2 text-gray-400">Address</label>
                        <textarea id="address" name="address"
                                  class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('address', $doctor->user->address) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Profile Image --}}
            <div class="flex flex-col items-center justify-start">
                <h5 class="text-lg font-medium text-gray-600 mb-4">Profile Image</h5>
                <div class="relative w-40 h-40">
                    <img id="imagePreview" 
                         src="{{ $doctor->user->getFirstMediaUrl('doctor-image') }}" 
                         class="w-40 h-40 object-cover rounded-full border border-gray-300 shadow-sm" 
                         alt="Profile Image">
                    <label for="doctor_image"
                        class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 cursor-pointer">
                        <i class="fa-solid fa-camera"></i>
                    </label>
                </div>
                <input type="file" name="doctor_image" id="doctor_image" class="hidden" accept="image/*">
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="mb-10">
            <h5 class="text-lg font-medium text-gray-600 mb-4">Contact Information</h5>
            <div class="card-body">
                <div class="mb-6">
                    <label for="phone" class="block text-sm mb-2 text-gray-400">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $doctor->user->phone) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="emergency_contact_name" class="block text-sm mb-2 text-gray-400">Emergency Contact Name</label>
                    <input type="text" id="emergency_contact_name" name="emergency_contact_name" 
                           value="{{ old('emergency_contact_name', $doctor->user->emergency_contact_name) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="emergency_contact_email" class="block text-sm mb-2 text-gray-400">Emergency Contact Email</label>
                    <input type="email" id="emergency_contact_email" name="emergency_contact_email" 
                           value="{{ old('emergency_contact_email', $doctor->user->emergency_contact_email) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="emergency_contact_relation" class="block text-sm mb-2 text-gray-400">Emergency Contact Relation</label>
                    <select id="emergency_contact_relation" name="emergency_contact_relation" 
                            class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        <option value="">Select Emergency Contact Relation</option>
                        @foreach ($relations as $relation)
                            <option value="{{ $relation->value }}" {{ old('emergency_contact_relation', $doctor->user->emergency_contact_relation) == $relation->value ? 'selected' : '' }}>
                                {{ $relation->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($doctor->user->emergency_contact_relation_other)
                    <div class="mb-6" id="relation_other_field">
                    @else
                    <div class="mb-6 hidden" id="relation_other_field">
                    @endif
                    <label for="emergency_contact_relation_other" class="block text-sm mb-2 text-gray-400">Specify the Relation</label>
                    <input type="text" id="emergency_contact_relation_other" name="emergency_contact_relation_other"
                           value="{{ old('emergency_contact_relation_other', $doctor->user->emergency_contact_relation_other) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="emergency_contact_phone" class="block text-sm mb-2 text-gray-400">Emergency Contact Phone</label>
                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" 
                           value="{{ old('emergency_contact_phone', $doctor->user->emergency_contact_phone) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>
            </div>
        </div>

        {{-- Professional Details --}}
        <div class="mb-10">
            <h5 class="text-lg font-medium text-gray-600 mb-4">Professional Details</h5>
            <div class="card-body">
                <div class="mb-6">
                    <label for="primary_specialization_id" class="block text-sm mb-2 text-gray-400">Primary Specialization</label>
                    <select name="primary_specialization_id" id="primary_specialization_id"
                            class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        <option value="">Select Primary Specialization</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}" {{ old('primary_specialization_id', $doctor->primary_specialization_id) == $spec->id ? 'selected' : '' }}>
                                {{ $spec->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="secondary_specialization_id" class="block text-sm mb-2 text-gray-400">Secondary Specialization</label>
                    <select name="secondary_specialization_id" id="secondary_specialization_id"
                            class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        <option value="">Select Secondary Specialization</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}" {{ old('secondary_specialization_id', $doctor->secondary_specialization_id) == $spec->id ? 'selected' : '' }}>
                                {{ $spec->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="license_number" class="block text-sm mb-2 text-gray-400">License Number</label>
                    <input type="text" name="license_number" id="license_number" value="{{ old('license_number', $doctor->license_number) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="license_expiry_date" class="block text-sm mb-2 text-gray-400">License Expiry Date</label>
                    <input type="date" name="license_expiry_date" id="license_expiry_date"
                           value="{{ old('license_expiry_date', $doctor->license_expiry_date->format('Y-m-d')) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="qualifications" class="block text-sm mb-2 text-gray-400">Qualifications</label>
                    <textarea name="qualifications" id="qualifications" 
                              class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('qualifications', $doctor->qualifications) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="years_of_experience" class="block text-sm mb-2 text-gray-400">Years of Experience</label>
                    <input type="text" name="years_of_experience" id="years_of_experience"
                           value="{{ old('years_of_experience', $doctor->years_of_experience) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>
            </div>
        </div>

        {{-- Account Settings --}}
        <div>
            <h5 class="text-lg font-medium text-gray-600 mb-4">Account Settings</h5>
            <div class="card-body">
                <div class="mb-6">
                    <label for="email" class="block text-sm mb-2 text-gray-400">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $doctor->user->email) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm mb-2 text-gray-400">Password</label>
                    <input type="password" name="password" id="password" placeholder="Leave blank to keep current"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-8">
            <a href="{{ route('doctor.list') }}" class="btn text-base py-2.5 px-6 text-gray-700 font-medium bg-gray-200 hover:bg-gray-300 rounded-md mr-3">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            <button type="submit" class="btn text-base py-2.5 px-6 text-white font-medium bg-blue-600 hover:bg-blue-700 rounded-md">
                <i class="fa-solid fa-save"></i> Update
            </button>
        </div>
    </form>
</div>

@endsection

@php
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Doctors List';
$pageActionLink = route('doctor.list');
@endphp



@section('custom-js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function () {
    // Live image preview
    $('#doctor_image').on('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            $('#imagePreview').attr('src', URL.createObjectURL(file));
        }
    });

    // Function to toggle "Specify the Relation" field
    function toggleRelationOther() {
        const selectedValue = $('#emergency_contact_relation').val();
        const otherValue = "{{ old('emergency_contact_relation', $doctor->user->emergency_contact_relation) }}";
        const hasOtherText = "{{ $doctor->user->emergency_contact_relation_other }}";

        // Show if selected value is "Other" OR if already has value
        if (selectedValue === 'Other' || hasOtherText) {
            $('#relation_other_field').show();
        } else {
            $('#relation_other_field').hide();
        }
    }

    // Initial check on page load
    toggleRelationOther();

    // Update on dropdown change
    $('#emergency_contact_relation').on('change', function () {
        toggleRelationOther();
    });
});
</script>




@endsection