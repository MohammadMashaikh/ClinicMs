@extends('layouts.master')


<script src="https://cdn.tailwindcss.com"></script>


@section('content')
<div class="card p-6">
    <h4 class="text-xl font-semibold text-gray-700 mb-6">Patient Profile</h4>

    <form action="{{ route('patient.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $patient->user->first_name) }}"
                               class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="last_name" class="block text-sm mb-2 text-gray-400">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $patient->user->last_name) }}"
                               class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="date_of_birth" class="block text-sm mb-2 text-gray-400">Date Of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" 
                               value="{{ old('date_of_birth', $patient->user->date_of_birth->format('Y-m-d')) }}"
                               class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="gender" class="block text-sm mb-2 text-gray-400">Gender</label>
                        <select id="gender" name="gender" class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Gender</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender->value }}" {{ old('gender', $patient->user->gender->value) == $gender->value ? 'selected' : '' }}>
                                    {{ $gender->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="address" class="block text-sm mb-2 text-gray-400">Address</label>
                        <textarea id="address" name="address"
                                  class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('address', $patient->user->address) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Profile Image --}}
            <div class="flex flex-col items-center justify-start">
                <h5 class="text-lg font-medium text-gray-600 mb-4">Profile Image</h5>
                <div class="relative w-40 h-40">
                    <img id="imagePreview" 
                         src="{{ $patient->user->getFirstMediaUrl('patient-image') }}" 
                         class="w-40 h-40 object-cover rounded-full border border-gray-300 shadow-sm" 
                         alt="Profile Image">
                    <label for="patient_image"
                        class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 cursor-pointer">
                        <i class="fa-solid fa-camera"></i>
                    </label>
                </div>
                <input type="file" name="patient_image" id="patient_image" class="hidden" accept="image/*">
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="mb-10">
            <h5 class="text-lg font-medium text-gray-600 mb-4">Contact Information</h5>
            <div class="card-body">
                <div class="mb-6">
                    <label for="phone" class="block text-sm mb-2 text-gray-400">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->user->phone) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="emergency_contact_name" class="block text-sm mb-2 text-gray-400">Emergency Contact Name</label>
                    <input type="text" id="emergency_contact_name" name="emergency_contact_name" 
                           value="{{ old('emergency_contact_name', $patient->user->emergency_contact_name) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="emergency_contact_email" class="block text-sm mb-2 text-gray-400">Emergency Contact Email</label>
                    <input type="email" id="emergency_contact_email" name="emergency_contact_email" 
                           value="{{ old('emergency_contact_email', $patient->user->emergency_contact_email) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="emergency_contact_relation" class="block text-sm mb-2 text-gray-400">Emergency Contact Relation</label>
                    <select id="emergency_contact_relation" name="emergency_contact_relation" 
                            class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        <option value="">Select Emergency Contact Relation</option>
                        @foreach ($relations as $relation)
                            <option value="{{ $relation->value }}" {{ old('emergency_contact_relation', $patient->user->emergency_contact_relation) == $relation->value ? 'selected' : '' }}>
                                {{ $relation->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($patient->user->emergency_contact_relation_other)
                    <div class="mb-6" id="relation_other_field">
                    @else
                    <div class="mb-6 hidden" id="relation_other_field">
                    @endif
                    <label for="emergency_contact_relation_other" class="block text-sm mb-2 text-gray-400">Specify the Relation</label>
                    <input type="text" id="emergency_contact_relation_other" name="emergency_contact_relation_other"
                           value="{{ old('emergency_contact_relation_other', $patient->user->emergency_contact_relation_other) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="emergency_contact_phone" class="block text-sm mb-2 text-gray-400">Emergency Contact Phone</label>
                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" 
                           value="{{ old('emergency_contact_phone', $patient->user->emergency_contact_phone) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>
            </div>
        </div>

        {{-- Medical Information --}}
        <div class="mb-10">
            <h5 class="text-lg font-medium text-gray-600 mb-4">Medical Information</h5>
            <div class="card-body">
                <div class="mb-6">
                    <label for="blood_type" class="block text-sm mb-2 text-gray-400">Blood Types</label>
                    <select name="blood_type" id="blood_type"
                            class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        <option value="">Select Blood Type</option>
                        @foreach($blood_types as $blood_type)
                            <option value="{{ $blood_type->value }}" {{ old('blood_type', $patient->blood_type->value) == $blood_type->value ? 'selected' : '' }}>
                                {{ $blood_type->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="weight" class="block text-sm mb-2 text-gray-400">Weight</label>
                    <input type="number" step="any" min="0" name="weight" id="weight" value="{{ old('weight', $patient->weight) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="height" class="block text-sm mb-2 text-gray-400">Height</label>
                    <input type="number" step="any" min="20" name="height" id="height" value="{{ old('license_number', $patient->height) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                <div class="mb-6">
                    <label for="allergies" class="block text-sm mb-2 text-gray-400">Alergic</label>
                    <textarea name="allergies" id="allergies" 
                              class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('allergies', $patient->allergies) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="current_medications" class="block text-sm mb-2 text-gray-400">Current Medications</label>
                    <textarea name="current_medications" id="current_medications" 
                              class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('current_medications', $patient->current_medications) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="chronic_diseases" class="block text-sm mb-2 text-gray-400">Chronic Diseases</label>
                    <textarea name="chronic_diseases" id="chronic_diseases" 
                              class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('chronic_diseases', $patient->chronic_diseases) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="past_surgeries" class="block text-sm mb-2 text-gray-400">Past Surgeries</label>
                    <textarea name="past_surgeries" id="past_surgeries" 
                              class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('past_surgeries', $patient->past_surgeries) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="previous_hospitalizations" class="block text-sm mb-2 text-gray-400">Previous Hospitalizations</label>
                    <textarea name="previous_hospitalizations" id="previous_hospitalizations" 
                              class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('previous_hospitalizations', $patient->previous_hospitalizations) }}</textarea>
                </div>

                <div class="mb-6">
                        <label class="block text-sm mb-4 text-gray-400">Family Medical History</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach (\App\Enums\FamilyMedicalHistoryEnums::cases() as $disease)
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="family_medical_history[]" value="{{ $disease->value }}" id="family_{{ $disease->value }}" 
                                     @if(
                                        in_array($disease->value, old('family_medical_history', $patient->family_medical_history ?? []))
                                    ) checked @endif
                                    >
                                    <label for="family_{{ $disease->value }}" class="text-sm text-gray-400">{{ $disease->value }}</label>
                                </div>
                            @endforeach
                        </div>
                </div>


                <div class="mb-6">
                    <label for="family_history_notes" class="block text-sm mb-2 text-gray-400">Family yHistory Notes</label>
                    <textarea name="family_history_notes" id="family_history_notes" 
                              class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">{{ old('family_history_notes', $patient->family_history_notes) }}</textarea>
                </div>

            </div>
        </div>




        {{-- Insurance Information --}}
        <div class="mb-10">
            <h5 class="text-lg font-medium text-gray-600 mb-4">Insurance Information</h5>
            <div class="card-body">

                <div class="mb-6">
                    <label for="insurance_provider" class="block text-sm mb-2 text-gray-400">Insurance Provider</label>
                    <input type="text" name="insurance_provider" id="insurance_provider" value="{{ old('insurance_provider', $patient->insurance_provider) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>


                <div class="mb-6">
                    <label for="policy_number" class="block text-sm mb-2 text-gray-400">Policy Number</label>
                    <input type="text" name="policy_number" id="policy_number" value="{{ old('policy_number', $patient->policy_number) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>


                <div class="mb-6">
                    <label for="policy_holder_name" class="block text-sm mb-2 text-gray-400">Policy Holder Name</label>
                    <input type="text" name="policy_holder_name" id="policy_holder_name" value="{{ old('policy_holder_name', $patient->policy_holder_name) }}"
                           class="py-3 px-4 text-gray-700 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                </div>

                 <div class="mb-6">
                        <label for="relationship_to_patient" class="block text-sm mb-2 text-gray-400">Relationship to Patient</label>
                        <select name="relationship_to_patient" id="relationship_to_patient" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Relationship</option>
                            @foreach($patient_relations as $patient_relation)
                                <option value="{{ $patient_relation->value }}" {{ old('relationship_to_patient', $patient->relationship_to_patient->value) ==  $patient_relation->value ? 'selected' : '' }}>{{ $patient_relation->value }}</option>
                            @endforeach
                        </select>
                 </div>


                 <div class="mb-6">
                    <label for="insurance_phone_number" class="block text-sm mb-2 text-gray-400">Insurance Phone Number</label>
                    <input type="text" name="insurance_phone_number" id="insurance_phone_number" value="{{ old('insurance_phone_number', $patient->insurance_phone_number) }}"
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
                    <input type="email" name="email" id="email" value="{{ old('email', $patient->user->email) }}"
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
            <a href="{{ route('patient.list') }}" class="btn text-base py-2.5 px-6 text-gray-700 font-medium bg-gray-200 hover:bg-gray-300 rounded-md mr-3">
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
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> patients List';
$pageActionLink = route('patient.list');
@endphp



@section('custom-js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function () {
    // Live image preview
    $('#patient_image').on('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            $('#imagePreview').attr('src', URL.createObjectURL(file));
        }
    });

    // Function to toggle "Specify the Relation" field
    function toggleRelationOther() {
        const selectedValue = $('#emergency_contact_relation').val();
        const otherValue = "{{ old('emergency_contact_relation', $patient->user->emergency_contact_relation) }}";
        const hasOtherText = "{{ $patient->user->emergency_contact_relation_other }}";

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