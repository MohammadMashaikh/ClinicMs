<?php

namespace App\Http\Controllers;

use App\Enums\MedicineFormEnums;
use App\Enums\MedicineTypeEnums;
use App\Enums\PharmacyCategoriesEnums;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PharmacyController extends Controller
{
   

    public function list()
    {
        return view('pharmacies.list');
    }



    public function create()
    {
        $categories = PharmacyCategoriesEnums::cases();
        $types = MedicineTypeEnums::cases();
        $forms = MedicineFormEnums::cases();
        return view('pharmacies.create', compact('categories', 'types', 'forms'));
    }



    public function show(Pharmacy $pharmacy)
    {
        return view('pharmacies.show', compact('pharmacy'));
    }



    public function storeStep1(Request $request)
    {
        $validatedData = $request->validate([
            'medicine_name' => 'required|string',
            'generic_name' => 'required|string',
            'category' => ['required', Rule::in(array_column(PharmacyCategoriesEnums::cases(), 'value'))],
            'medicine_type' => ['required', Rule::in(array_column(MedicineTypeEnums::cases(), 'value'))],
            'description' => 'nullable|string',
            'medicine_form' => ['required', Rule::in(array_column(MedicineFormEnums::cases(), 'value'))]
        ]);

        $request->session()->put('basic_information', $validatedData);
        return response()->json(['success' => true]);
    }



    public function storeStep2(Request $request)
    {
        $validatedData = $request->validate([
            'manufacturer' => 'required|string',
            'supplier' => 'required|string',
            'manufacturing_date' => 'required|date',
            'expiry_date' => 'required|date|after:manufacturing_date',
            'batch_number' => 'nullable|string',
            'dosage' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'precautions_warnings' => 'nullable|string',
        ]);

        $request->session()->put('detailed_information', $validatedData);
        return response()->json(['success' => true]);
    }




    public function storeStep3(Request $request)
    {
        $validatedData = $request->validate([
            'buying_price'   => 'required|numeric|decimal:2|min:0',
            'selling_price'  => 'required|numeric|decimal:2|min:0',
            'quantity'       => 'required|integer|min:0',
            'reorder_level'  => 'required|integer|min:0',
            'tax_rate'       => 'required|numeric|decimal:2|min:0|max:100',
        ]);

        
        $step1 = $request->session()->get('basic_information');
        $step2 = $request->session()->get('detailed_information');

        if (!$step1 || !$step2) {
            return response()->json(['success' => false, 'message' => 'Step data missing']);
        }

        Pharmacy::create([
            'medicine_name' => $step1['medicine_name'],
            'generic_name' => $step1['generic_name'],
            'category' => $step1['category'],
            'medicine_type' => $step1['medicine_type'],
            'description' => $step1['description'] ?? null,
            'medicine_form' => $step1['medicine_form'],
            'manufacturer' => $step2['manufacturer'],
            'supplier' => $step2['supplier'],
            'manufacturing_date' => $step2['manufacturing_date'],
            'expiry_date' => $step2['expiry_date'],
            'batch_number' => $step2['batch_number'] ?? null,
            'dosage' => $step2['dosage'] ?? null,
            'side_effects' => $step2['side_effects'],
            'precautions_warnings' => $step2['precautions_warnings'],
            'buying_price' => $validatedData['buying_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'reorder_level' => $validatedData['reorder_level'],
            'tax_rate' => $validatedData['tax_rate']
        ]);

        $request->session()->forget(['basic_information', 'detailed_information']);

        return response()->json(['success' => true]);
    }



}
