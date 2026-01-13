
@extends('layouts.master')

@section('content')

    <div class="flex gap-5 bg-gray-100 p-3 rounded-lg">
        <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-blue-600 text-white cursor-pointer">
            Basic Information
        </h6>
        <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-white text-gray-600 cursor-pointer shadow">
            Detailed Information
        </h6>
        <h6 class="step-indicator text-md font-semibold px-4 py-2 rounded-lg bg-white text-gray-600 cursor-pointer shadow">
            Inventory & Pricing
        </h6>
    </div>


    {{-- STEP 1: Basic Information --}}
    <form id="step1-form" class="step">
        @csrf
        <div class="card-body flex flex-col gap-6">
            <div class="card">
                <div class="card-body">
                    <h6>Basic Information</h6>
                    <p class="mb-6 mt-3 text-gray-300">Enter the basic details of the medicine</p>

                    <div class="mb-6">
                        <label for="medicine_name" class="block text-sm mb-2 text-gray-400">Medicine Name <sup class="text-red-500">*</sup></label>
                        <input type="text" name="medicine_name" id="medicine_name" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="generic_name" class="block text-sm mb-2 text-gray-400">Generic Name <sup class="text-red-500">*</sup></label>
                        <input type="text" name="generic_name" id="generic_name" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">  
                        <label for="category" class="block text-sm mb-2 text-gray-400">Category <sup class="text-red-500">*</sup></label>
                        <select name="category" id="category" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->value }}">{{ $category->value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="medicine_type" class="block text-sm mb-2 text-gray-400">Medicine Type <sup class="text-red-500">*</sup></label>
                        <select name="medicine_type" id="medicine_type" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                            <option value="">Select type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->value }}">{{ $type->value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm mb-2 text-gray-400">Description</label>
                        <textarea name="description" id="description" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0"></textarea>
                    </div>


                    <div class="mb-6">
                        <label for="medicine_form" class="block text-sm mb-2 text-gray-400">
                            Medicine Form <sup class="text-red-500">*</sup>
                        </label>

                        <div class="flex flex-wrap gap-6">
                            @foreach ($forms as $form)
                                <label class="flex items-center gap-2 text-gray-700">
                                    <input
                                        type="radio"
                                        name="medicine_form"
                                        value="{{ $form->value }}"
                                        class="text-blue-600 focus:ring-blue-500"
                                    >
                                    <span>{{ $form->value }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>


                </div>
            </div>


            <div class="flex justify-end">
                <button type="submit" class="btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-blue-600 hover:bg-blue-700 rounded-md">
                    <i class="fa-solid fa-arrow-right"></i> Next
                </button>
            </div>

        </div>
    </form>






    {{-- STEP 2: Detailed Information --}}
    <form id="step2-form" class="step hidden">
        @csrf
        <div class="card-body flex flex-col gap-6">
            <div class="card">
                <div class="card-body">
                    <h6>Detailed Information</h6>
                    <p class="mb-6 mt-3 text-gray-300">Enter detailed specifications of the medicine</p>

                    <div class="mb-6">
                        <label for="manufacturer" class="block text-sm mb-2 text-gray-400">Manufacturer <sup class="text-red-500">*</sup></label>
                        <input type="text" name="manufacturer" id="manufacturer" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="supplier" class="block text-sm mb-2 text-gray-400">Supplier <sup class="text-red-500">*</sup></label>
                        <input type="text" name="supplier" id="supplier" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="manufacturing_date" class="block text-sm mb-2 text-gray-400">Manufacturing Date <sup class="text-red-500">*</sup></label>
                        <input type="date" name="manufacturing_date" id="manufacturing_date" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="expiry_date" class="block text-sm mb-2 text-gray-400">Expiry Date <sup class="text-red-500">*</sup></label>
                        <input type="date" name="expiry_date" id="expiry_date" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="batch_number" class="block text-sm mb-2 text-gray-400">Batch Number</label>
                        <input type="text" name="batch_number" id="batch_number" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="dosage" class="block text-sm mb-2 text-gray-400">Dosage</label>
                        <input type="text" name="dosage" id="dosage" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>


                    <div class="mb-6">
                        <label for="side_effects" class="block text-sm mb-2 text-gray-400">Side Effects</label>
                        <textarea name="side_effects" id="side_effects" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        </textarea>
                    </div>

                    <div class="mb-6">
                        <label for="precautions_warnings" class="block text-sm mb-2 text-gray-400">Precautions & Warnings</label>
                        <textarea name="precautions_warnings" id="precautions_warnings" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                        </textarea>
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





     {{-- STEP 3: Inventory & Pricing --}}
    <form id="step3-form" class="step hidden">
        @csrf
        <div class="card-body flex flex-col gap-6">
            <div class="card">
                <div class="card-body">
                    <h6>Inventory & Pricing</h6>
                    <p class="mb-6 mt-3 text-gray-300">Enter inventory and pricing details</p>

                    <div class="mb-6">
                        <label for="quantity" class="block text-sm mb-2 text-gray-400">Initial Quantity <sup class="text-red-500">*</sup></label>
                        <input type="number" min="0" name="quantity" id="quantity" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="reorder_level" class="block text-sm mb-2 text-gray-400">Reorder Level <sup class="text-red-500">*</sup></label>
                        <input type="number" min="0" name="reorder_level" id="reorder_level" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="buying_price" class="block text-sm mb-2 text-gray-400">Purchasing Price <sup class="text-red-500">*</sup></label>
                        <input type="number" min="0" name="buying_price" id="buying_price" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="selling_price" class="block text-sm mb-2 text-gray-400">Selling Price <sup class="text-red-500">*</sup></label>
                        <input type="number" min="0" name="selling_price" id="selling_price" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                    <div class="mb-6">
                        <label for="tax_rate" class="block text-sm mb-2 text-gray-400">Tax Rate (%)</label>
                        <input type="number" min="0" name="tax_rate" id="tax_rate" class="py-3 px-4 text-gray-500 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0">
                    </div>

                </div>
            </div>


            <div class="flex justify-between">
                <button type="button" class="prev btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-gray-400 hover:bg-gray-500 rounded-md">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </button>
                <button type="submit" class="btn text-base py-2.5 mb-12 text-white font-medium w-fit bg-blue-600 hover:bg-blue-700 rounded-md">
                    <i class="fa-solid fa-check"></i> Finish
                </button>
            </div>

        </div>
    </form>



@endsection



@php
 
$pageActionText = '<i class="fa-solid fa-arrow-left-long"></i> Pharmaciests List';
$pageActionLink = route('pharmacy.list');

@endphp



@section('custom-js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {


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
            url: "{{ route('pharmacy.storeStep1') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
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
            url: "{{ route('pharmacy.storeStep2') }}",
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
    $('.text-red-500').remove();

    let formData = new FormData(this); // use FormData to include files

    $.ajax({
        url: "{{ route('pharmacy.storeStep3') }}",
        method: "POST",
        data: formData,
        processData: false, // important for FormData
        contentType: false, // important for FormData
        success: function(res){
            if(res.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Medicine Created Successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('pharmacy.list') }}";
                });

            } else {
                console.log(errors);
                
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

