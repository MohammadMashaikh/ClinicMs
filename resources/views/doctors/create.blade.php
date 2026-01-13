
@extends('layouts.master')

@section('content')

    <div class="flex gap-5 bg-gray-100 p-3 rounded-lg mb-5">
    <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-blue-600 text-white cursor-pointer">
        Personal Information
    </h6>
    <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-white text-gray-600 cursor-pointer shadow">
        Professional Details
    </h6>
    <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-white text-gray-600 cursor-pointer shadow">
        Account Settings
    </h6>
</div>

    @include('layouts.personal-details')

    {{-- STEP 2: Professional Details --}}
    <form id="step2-form" class="step hidden">
        @csrf
        <div class="card-body flex flex-col gap-6">
            <h6>Professional Details</h6>
            <p class="text-gray-300">Enter the doctor's professional details.</p>
            <div class="card">
                <div class="card-body">

                    <div class="mb-6">
                        <label for="primary_specialization_id" class="block text-sm mb-2 text-gray-400">Primary Specialization</label>
                        <select name="primary_specialization_id" id="primary_specialization_id" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Primary Specialization</option>
                            @foreach($specializations as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="secondary_specialization_id" class="block text-sm mb-2 text-gray-400">Secondary Specialization</label>
                        <select name="secondary_specialization_id" id="secondary_specialization_id" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Secondary Specialization</option>
                            @foreach($specializations as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="license_number" class="block text-sm mb-2 text-gray-400">License Number</label>
                        <input type="text" name="license_number" id="license_number" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="license_expiry_date" class="block text-sm mb-2 text-gray-400">License Expiry Date</label>
                        <input type="date" name="license_expiry_date" id="license_expiry_date" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="qualifications" class="block text-sm mb-2 text-gray-400">Qualifications</label>
                        <textarea name="qualifications" id="qualifications" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="years_of_experience" class="block text-sm mb-2 text-gray-400">Years of Experience</label>
                        <input type="text" name="years_of_experience" id="years_of_experience" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" class="prev btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-gray-400 hover:bg-gray-500 rounded-md">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </button>
                <button type="submit" class="btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-blue-600 hover:bg-blue-700 rounded-md">
                    <i class="fa-solid fa-arrow-right"></i> Next
                </button>
            </div>
        </div>
    </form>

    {{-- STEP 3: Account Settings --}}
    <form id="step3-form" class="step hidden">
        @csrf
        <div class="card-body flex flex-col gap-6">
            <h6>Account Settings</h6>
            <p class="text-gray-300">Enter the doctor's account settings.</p>

            <div class="mb-6 flex flex-col items-center">
                <label class="block text-sm mb-2 text-gray-400">Profile Image</label>
                <div class="relative w-32 h-32">
                    <img id="imagePreview" 
                        src="{{ asset('images/default-profile.png') }}" 
                        class="w-32 h-32 object-cover rounded-full border border-gray-300 shadow-sm" 
                        alt="Profile Image">
                    <label for="profile_image"
                        class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 cursor-pointer">
                        <i class="fa-solid fa-camera"></i>
                    </label>
                </div>
                <input type="file" name="profile_image" id="profile_image" class="hidden" accept="image/*">
           </div>


            <div class="card">
                <div class="card-body">
                    <div class="mb-6">
                        <label for="email" class="block text-sm mb-2 text-gray-400">Email</label>
                        <input type="email" name="email" id="email" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm mb-2 text-gray-400">Password</label>
                        <input type="password" name="password" id="password" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" class="prev btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-gray-400 hover:bg-gray-500 rounded-md">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </button>
                <button type="submit" class="btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-green-600 hover:bg-green-700 rounded-md">
                    <i class="fa-solid fa-check"></i> Finish
                </button>
            </div>
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
$(document).ready(function() {

    // Dynamic Emergency Contact Other
    $('#emergency_contact_relation').change(function(){
        if($(this).val() === "Other"){
            $('#relation_other_field').removeClass('hidden');
        } else {
            $('#relation_other_field').addClass('hidden').find('input').val('');
        }
    });

    function showStep(stepId){
        $('.step').addClass('hidden');
        $(stepId).removeClass('hidden');
    }

    function updateStepIndicator(step){
        $('.step-indicator').removeClass('bg-blue-600 text-white').addClass('bg-white text-gray-600 shadow');
        $('.step-indicator').eq(step-1).removeClass('bg-white text-gray-600 shadow').addClass('bg-blue-600 text-white');
    }

    function handleErrors(xhr){
        if(xhr.status === 422){
            let errors = xhr.responseJSON.errors;
            $('.text-red-500').remove(); // clear old errors
            $.each(errors, function(field, messages){
                let input = $('[name="'+field+'"]');
                if(input.length){
                    input.after('<p class="text-red-500 text-sm mt-1">'+messages[0]+'</p>');
                }
            });
        } else {
            alert("Something went wrong. Please try again.");
        }
    }

    // STEP 1
    $('#step1-form').submit(function(e){
        e.preventDefault();
        $('.text-red-500').remove(); // clear old errors
        $.ajax({
            url: "{{ route('doctor.storeStep1') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    // ✅ Add user_id returned from backend as hidden input to step2 form
                    if(res.user_id){
                        if($('#step2-form input[name="user_id"]').length === 0){
                            $('#step2-form').append('<input type="hidden" name="user_id" value="'+res.user_id+'">');
                        } else {
                            $('#step2-form input[name="user_id"]').val(res.user_id);
                        }
                    }

                    showStep('#step2-form');
                    updateStepIndicator(2);
                }
            },
            error: function(xhr){
                handleErrors(xhr);
            }
        });
    });

    // STEP 2
    $('#step2-form').submit(function(e){
        e.preventDefault();
        $('.text-red-500').remove(); // clear old errors
        $.ajax({
            url: "{{ route('doctor.storeStep2') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    showStep('#step3-form');
                    updateStepIndicator(3);
                }
            },
            error: function(xhr){
                handleErrors(xhr);
            }
        });
    });


    // Live preview for profile image
    $('#profile_image').change(function(e){
        const reader = new FileReader();
        reader.onload = function(e){
            $('#imagePreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });



    // STEP 3
    $('#step3-form').submit(function(e){
    e.preventDefault();
    $('.text-red-500').remove();

    let formData = new FormData(this); // use FormData to include files

    $.ajax({
        url: "{{ route('doctor.storeStep3') }}",
        method: "POST",
        data: formData,
        processData: false, // important for FormData
        contentType: false, // important for FormData
        success: function(res){
            if(res.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Doctor Created Successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('doctor.list') }}";
                });

            }
        },
        error: function(xhr){
            handleErrors(xhr);
        }
    });
});


    // Back buttons
    $('.prev').click(function(){
        let currentStep = $(this).closest('form').attr('id');
        if(currentStep === 'step2-form'){ showStep('#step1-form'); updateStepIndicator(1); }
        if(currentStep === 'step3-form'){ showStep('#step2-form'); updateStepIndicator(2); }
    });
});
</script>
@endsection

