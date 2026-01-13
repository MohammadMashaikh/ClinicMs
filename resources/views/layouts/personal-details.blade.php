
<div class="card">

    {{-- STEP 1: Personal Information --}}
    <form id="step1-form" class="step">
        @csrf
        <div class="card-body flex flex-col gap-6">
            <h6>Personal Information</h6>
            <p class="text-gray-300">Enter the {{ Request::routeIs('doctor.*') ? "doctor's" : "patient's" }} personal details.</p>
            <div class="card">
                <div class="card-body">
                    <div class="mb-6">
                        <label for="first_name" class="block text-sm mb-2 text-gray-400">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="last_name" class="block text-sm mb-2 text-gray-400">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="date_of_birth" class="block text-sm mb-2 text-gray-400">Date Of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="gender" class="block text-sm mb-2 text-gray-400">Gender</label>
                        <select id="gender" name="gender" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Gender</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender->value }}">{{ $gender->value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="address" class="block text-sm mb-2 text-gray-400">Address</label>
                        <textarea id="address" name="address" class="text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
                    </div>
                </div>
            </div>

            <hr>

            {{-- Contact Information --}}
            <h6>Contact Information</h6>
            <p class="text-gray-300">Enter the {{ Request::routeIs('doctor.*') ? "doctor's" : "patient's" }} contact details.</p>
            <div class="card">
                <div class="card-body">
                    <div class="mb-6">
                        <label for="phone" class="block text-sm mb-2 text-gray-400">Phone</label>
                        <input type="text" id="phone" name="phone" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="emergency_contact_name" class="block text-sm mb-2 text-gray-400">Emergency Contact Name</label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="emergency_contact_email" class="block text-sm mb-2 text-gray-400">Emergency Contact Email</label>
                        <input type="email" id="emergency_contact_email" name="emergency_contact_email" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="emergency_contact_relation" class="block text-sm mb-2 text-gray-400">Emergency Contact Relation</label>
                        <select id="emergency_contact_relation" name="emergency_contact_relation" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Emergency Contact Relation</option>
                            @foreach ($relations as $relation)
                                <option value="{{ $relation->value }}">{{ $relation->value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6 hidden" id="relation_other_field">
                        <label for="emergency_contact_relation_other" class="block text-sm mb-2 text-gray-400">Specify the Relation</label>
                        <input type="text" id="emergency_contact_relation_other" name="emergency_contact_relation_other" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="emergency_contact_phone" class="block text-sm mb-2 text-gray-400">Emergency Contact Phone</label>
                        <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-blue-600 hover:bg-blue-700 rounded-md">
                    <i class="fa-solid fa-arrow-right"></i> Next
                </button>
            </div>
        </div>
    </form>