<?php

namespace App\Http\Controllers;

use App\Enums\BloodTypesEnums;
use App\Enums\EmergencyContactRelationEnums;
use App\Enums\FamilyMedicalHistoryEnums;
use App\Enums\GenderEnums;
use App\Enums\InsuranceRelationshipToPatient;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{


    public function index()
    {
        return view('patients.index');
    }



    public function create()
    {
        $blood_types = BloodTypesEnums::cases();
        $genders = GenderEnums::cases();
        $relations = EmergencyContactRelationEnums::cases();
        return view('patients.create', compact('blood_types', 'genders', 'relations'));
    }



    public function storeStep1(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string',
            'gender' => ['required', Rule::in(array_column(GenderEnums::cases(), 'value'))],
            'address' => 'required|string',
            'emergency_contact_name' => 'required|string|max:50',
            'emergency_contact_email' => 'nullable|string|email',
            'emergency_contact_relation' => ['required', Rule::in(array_column(EmergencyContactRelationEnums::cases(), 'value'))],
            'emergency_contact_phone' => 'required|string',
            'emergency_contact_relation_other' => 'nullable|required_if:emergency_contact_relation,Other|string|max:50'
        ]);

        // Save step 1 in session
        $request->session()->put('patient_step1', $validatedData);

        return response()->json(['success' => true]);
    }



    // STEP 2: Professional Details
    public function storeStep2(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id', // optional for now
            'blood_type' => ['required', Rule::in(array_column(BloodTypesEnums::cases(), 'value'))],
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'chronic_diseases' => 'nullable|string',
            'past_surgeries' => 'nullable|string',
            'previous_hospitalizations' => 'nullable|string',
            'family_medical_history' => ['nullable', 'array'],
            'family_medical_history.*' => [Rule::in(array_column(FamilyMedicalHistoryEnums::cases(), 'value'))],
            'family_history_notes' => 'nullable|string',
        ]);

        // Save step 2 in session
        $request->session()->put('patient_step2', $validatedData);

        return response()->json(['success' => true]);
    }


    // Step 3: Insurance Details
    public function storeStep3(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id', // optional for now
            'insurance_provider' => 'required|string',
            'policy_number' => 'required|string',
            'policy_holder_name' => 'required|string',
            'relationship_to_patient' => ['required', Rule::in(array_column(InsuranceRelationshipToPatient::cases(), 'value'))],
            'insurance_phone_number' => 'required|string',
        ]);

        $request->session()->put('patient_step3' ,$validatedData);

        return response()->json(['success' => true]);
            
    }




    // STEP 4: Account Settings + Final Submission
    public function storeStep4(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'profile_image' => 'nullable|image',
        ]);

        // Merge all steps
        $step1 = $request->session()->get('patient_step1');
        $step2 = $request->session()->get('patient_step2');
        $step3 = $request->session()->get('patient_step3');

        if (!$step1 || !$step2) {
            return response()->json(['success' => false, 'message' => 'Step data missing']);
        }

        $full_name = $step1['first_name'] . ' ' . $step1['last_name'];

        $user = User::create([
            'first_name' => $step1['first_name'],
            'last_name' => $step1['last_name'],
            'full_name' => $full_name,
            'date_of_birth' => $step1['date_of_birth'],
            'phone' => $step1['phone'],
            'gender' => $step1['gender'],
            'address' => $step1['address'],
            'emergency_contact_name' => $step1['emergency_contact_name'],
            'emergency_contact_email' => $step1['emergency_contact_email'] ?? null,
            'emergency_contact_relation' => $step1['emergency_contact_relation'],
            'emergency_contact_phone' => $step1['emergency_contact_phone'],
            'emergency_contact_relation_other' => $step1['emergency_contact_relation_other'] ?? null,
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);


        
            Patient::create([
            'user_id' => $user->id,
            'blood_type' => $step2['blood_type'],
            'height' => $step2['height'],
            'weight' => $step2['weight'],
            'allergies' => $step2['allergies'] ?? null,
            'current_medications' => $step2['current_medications'] ?? null,
            'chronic_diseases' => $step2['chronic_diseases'] ?? null,
            'past_surgeries' => $step2['past_surgeries'] ?? null,
            'previous_hospitalizations' => $step2['previous_hospitalizations'] ?? null,
            'family_medical_history' => $step2['family_medical_history'] ?? null,
            'family_history_notes' => $step2['family_history_notes'] ?? null,
            'insurance_provider' => $step3['insurance_provider'],
            'policy_number' => $step3['policy_number'],
            'policy_holder_name' => $step3['policy_holder_name'],
            'relationship_to_patient' => $step3['relationship_to_patient'],
            'insurance_phone_number' => $step3['insurance_phone_number'],
            
        ]);

        $user->assignRole('patient');

        if ($request->hasFile('profile_image')) {
            $user->addMedia($request->file('profile_image'))->toMediaCollection('patient-image');
        }

        // Clear session
        $request->session()->forget(['patient_step1', 'patient_step2', 'patient_step3']);

        return response()->json(['success' => true]);
    }




    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }



    public function edit(Patient $patient)
    {
        $blood_types = BloodTypesEnums::cases();
        $genders = GenderEnums::cases();
        $relations = EmergencyContactRelationEnums::cases();
        $patient_relations = InsuranceRelationshipToPatient::cases();
        return view('patients.edit', compact('patient', 'blood_types', 'genders', 'relations', 'patient_relations'));
    }




    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $userId = $patient->user_id;


        $validatedData = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => ['required', Rule::in(array_column(GenderEnums::cases(), 'value'))],
            'address' => 'required|string',
            'phone' => 'required|string',
            'emergency_contact_name' => 'required|string|max:50',
            'emergency_contact_email' => 'nullable|string|email',
            'emergency_contact_relation' => ['required', Rule::in(array_column(EmergencyContactRelationEnums::cases(), 'value'))],
            'emergency_contact_phone' => 'required|string',

            'email' => 'required|email|unique:users,email,' . $userId . ',id',
            'password' => 'nullable|min:8',

            'blood_type' => ['required', Rule::in(array_column(BloodTypesEnums::cases(), 'value'))],
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'chronic_diseases' => 'nullable|string',
            'past_surgeries' => 'nullable|string',
            'previous_hospitalizations' => 'nullable|string',
            'family_medical_history' => ['nullable', 'array'],
            'family_medical_history.*' => [Rule::in(array_column(FamilyMedicalHistoryEnums::cases(), 'value'))],
            'family_history_notes' => 'nullable|string',

            'insurance_provider' => 'required|string',
            'policy_number' => 'required|string',
            'policy_holder_name' => 'required|string',
            'relationship_to_patient' => ['required', Rule::in(array_column(InsuranceRelationshipToPatient::cases(), 'value'))],
            'insurance_phone_number' => 'required|string',

            'doctor_image' => 'nullable|image'
        ]);


        $full_name = $validatedData['first_name'] . ' ' . $validatedData['last_name'];

        $user_data = collect($validatedData)->only(
            'first_name',
            'last_name',
            'date_of_birth',
            'phone',
            'gender',
            'address',
            'emergency_contact_name',
            'emergency_contact_email', 
            'emergency_contact_relation',
            'emergency_contact_phone',
            'email',
            'password'
        )->toArray();


        $user_data['full_name'] = $full_name;

        if (!empty($user_data['password'])) {
            $user_data['password'] = bcrypt($user_data['password']);
        } else {
            unset($user_data['password']);
        }

        
        $user = User::findOrFail($userId);
        $user->update($user_data);



        $patient_data = collect($validatedData)->only(
            'blood_type',
            'height',
            'weight',
            'allergies',
            'current_medications',
            'chronic_diseases',
            'past_surgeries',
            'previous_hospitalizations',
            'family_medical_history',
            'family_history_notes',
            'insurance_provider',
            'policy_number',
            'policy_holder_name',
            'relationship_to_patient',
            'insurance_phone_number',
        )->toArray();



        $patient->update($patient_data);


        if ($request->hasFile('patient_image'))
        {
            $user->clearMediaCollection('patient-image');
            $user->addMedia($request->patient_image)->toMediaCollection('patient-image');
        }


        return redirect()->route('patient.list')->with('success', 'Patient Updated Successfully');

    }
}
