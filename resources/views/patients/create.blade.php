
@extends('layouts.master')

@section('content')

    <div class="flex gap-5 bg-gray-100 p-3 rounded-lg mb-5">
        <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-blue-600 text-white cursor-pointer">
            Personal Information
        </h6>
        <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-white text-gray-600 cursor-pointer shadow">
            Medical Information
        </h6>
        <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-white text-gray-600 cursor-pointer shadow">
            Insurance
        </h6>
        <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-white text-gray-600 cursor-pointer shadow">
            Account Settings
        </h6>
    </div>

    @include('layouts.personal-details')

    {{-- STEP 2: Medical Information --}}
    <form id="step2-form" class="step hidden">
        @csrf
        <div class="card-body flex flex-col gap-6">
            <h6>Medical Information</h6>
            <p class="text-gray-300">Enter the patient's Medical history and details.</p>
            <div class="card">
                <div class="card-body">
                    <div class="mb-6">
                        <label for="blood_type" class="block text-sm mb-2 text-gray-400">Blood Type</label>
                        <select name="blood_type" id="blood_type" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Blood Type</option>
                            @foreach($blood_types as $type)
                                <option value="{{ $type->value }}">{{ $type->value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="height" class="block text-sm mb-2 text-gray-400">Height</label>
                        <input type="number" min="20" name="height" id="height" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="weight" class="block text-sm mb-2 text-gray-400">Weight</label>
                        <input type="number" min="0" name="weight" id="weight" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="allergies" class="block text-sm mb-2 text-gray-400">Alergic</label>
                        <textarea name="allergies" id="allergies" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="current_medications" class="block text-sm mb-2 text-gray-400">Current Medications</label>
                        <textarea name="current_medications" id="current_medications" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
                    </div>

                </div>
            </div> 


                <hr>
            {{-- Medical History --}}
            <h6>Medical History</h6>
                <div class="card">
                 <div class="card-body">
                     <div class="mb-6">
                        <label for="past_surgeries" class="block text-sm mb-2 text-gray-400">Past Surgeries</label>
                        <textarea name="past_surgeries" id="past_surgeries" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
                    </div>

                   <div class="mb-6">
                        <label for="previous_hospitalizations" class="block text-sm mb-2 text-gray-400">Previous Hospitalizations</label>
                        <textarea name="previous_hospitalizations" id="previous_hospitalizations" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
                   </div>

                    <div class="mb-6">
                        <label class="block text-sm mb-4 text-gray-400">Family Medical History</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach (\App\Enums\FamilyMedicalHistoryEnums::cases() as $disease)
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="family_medical_history[]" value="{{ $disease->value }}" id="family_{{ $disease->value }}">
                                    <label for="family_{{ $disease->value }}" class="text-sm text-gray-400">{{ $disease->value }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="mb-6">
                        <label for="family_history_notes" class="block text-sm mb-2 text-gray-400">Additional Family History Notes</label>
                        <textarea name="family_history_notes" id="family_history_notes" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
                    </div>


                    <div class="mb-6">
                        <label for="chronic_diseases" class="block text-sm mb-2 text-gray-400">Chronic Diseases</label>
                        <textarea name="chronic_diseases" id="chronic_diseases" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
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

            


        </div>
    </form>






    {{-- STEP 3: Insurace --}}
    <form id="step3-form" class="step hidden">
        @csrf
        <div class="card-body flex flex-col gap-6">

            <div class="card">
                <div class="card-body">
                     <h6>Insurance</h6>
                     <p class="text-gray-300 mb-6">Enter the patient's Insurance.</p>
                    <div class="mb-6">
                        <label for="insurance_provider" class="block text-sm mb-2 text-gray-400">Insurance Provider</label>
                        <input type="text" name="insurance_provider" id="insurance_provider" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="policy_number" class="block text-sm mb-2 text-gray-400">Policy Number</label>
                        <input type="text" name="policy_number" id="policy_number" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="policy_holder_name" class="block text-sm mb-2 text-gray-400">Policy Holder Name</label>
                        <input type="text" name="policy_holder_name" id="policy_holder_name" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                      <div class="mb-6">
                        <label for="relationship_to_patient" class="block text-sm mb-2 text-gray-400">Relationship to Patient</label>
                        <select name="relationship_to_patient" id="relationship_to_patient" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select Relationship</option>
                            @foreach(\App\Enums\InsuranceRelationshipToPatient::cases() as $patient_relation)
                                <option value="{{ $patient_relation->value }}">{{ $patient_relation->value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="insurance_phone_number" class="block text-sm mb-2 text-gray-400">Insurance Phone Number</label>
                        <input type="text" name="insurance_phone_number" id="insurance_phone_number" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="flex justify-between">
                        <button type="button" class="prev btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-gray-400 hover:bg-gray-500 rounded-md">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </button>
                        <button type="submit" class="btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-green-600 hover:bg-green-700 rounded-md">
                            <i class="fa-solid fa-check"></i> Next
                        </button>
                   </div>

                </div>
             </div>

             
     </div>

            
    </form>



    {{-- STEP 4: Account Settings --}}
    <form id="step4-form" class="step hidden">
        @csrf
        <div class="card-body flex flex-col gap-6">
           <div class="card">
            <h6>Account Settings</h6>
            <p class="text-gray-300">Enter the patient's account settings.</p>
          </div>
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

@endsection



@php
 
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Patients List';
$pageActionLink = route('patient.list');

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

        // Ensure the "Other" field is sent
        if($('#relation_other_field').hasClass('hidden')){
            $('#emergency_contact_relation_other').val('');
        }


        $('.text-red-500').remove(); // clear old errors
        $.ajax({
            url: "{{ route('patient.storeStep1') }}",
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
                console.log(xhr.responseJSON);
                handleErrors(xhr);
            }
        });
    });

    // STEP 2
    $('#step2-form').submit(function(e){
        e.preventDefault();
        $('.text-red-500').remove(); // clear old errors
        $.ajax({
            url: "{{ route('patient.storeStep2') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    showStep('#step3-form');
                    updateStepIndicator(3);
                }
            },
            error: function(xhr){
            console.log(xhr.responseJSON);
                handleErrors(xhr);
            }
        });
    });


    // STEP 3
    $('#step3-form').submit(function(e){
        e.preventDefault();
        $('.text-red-500').remove(); // clear old errors
        $.ajax({
            url: "{{ route('patient.storeStep3') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    showStep('#step4-form');
                    updateStepIndicator(4);
                }
            },
            error: function(xhr){
            console.log(xhr.responseJSON);
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



    // STEP 4
    $('#step4-form').submit(function(e){
    e.preventDefault();
    $('.text-red-500').remove();

    let formData = new FormData(this); // use FormData to include files

    $.ajax({
        url: "{{ route('patient.storeStep4') }}",
        method: "POST",
        data: formData,
        processData: false, // important for FormData
        contentType: false, // important for FormData
        success: function(res){
            if(res.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Patient Created Successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('patient.list') }}";
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
        if(currentStep === 'step4-form'){ showStep('#step3-form'); updateStepIndicator(3); }
    });
});
</script>
@endsection

