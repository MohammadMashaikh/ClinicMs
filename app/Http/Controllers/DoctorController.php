<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\GenderEnums;
use App\Enums\EmergencyContactRelationEnums;
use App\Models\DoctorSchedule;
use App\Models\Specialization;
use App\Models\User;

class DoctorController extends Controller
{
    

    public function index()
    {
        return view('doctors.index');
    }


    public function create()
    {

        $specializations = Specialization::all();
        $genders = GenderEnums::cases();
        $relations = EmergencyContactRelationEnums::cases();
        return view('doctors.create', compact('specializations', 'genders', 'relations'));
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
        $request->session()->put('doctor_step1', $validatedData);

        return response()->json(['success' => true]);
    }



    // STEP 2: Professional Details
    public function storeStep2(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id', // optional for now
            'primary_specialization_id' => 'required|exists:specializations,id',
            'secondary_specialization_id' => 'nullable|exists:specializations,id',
            'license_number' => 'required|string',
            'license_expiry_date' => 'required|date',
            'qualifications' => 'required|string',
            'years_of_experience' => 'required|integer',
        ]);

        // Save step 2 in session
        $request->session()->put('doctor_step2', $validatedData);

        return response()->json(['success' => true]);
    }


    // STEP 3: Account Settings + Final Submission
    public function storeStep3(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'profile_image' => 'nullable|image',
        ]);

        // Merge all steps
        $step1 = $request->session()->get('doctor_step1');
        $step2 = $request->session()->get('doctor_step2');

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

            Doctor::create([
            'user_id' => $user->id,
            'primary_specialization_id' => $step2['primary_specialization_id'],
            'secondary_specialization_id' => $step2['secondary_specialization_id'] ?? null,
            'license_number' => $step2['license_number'],
            'license_expiry_date' => $step2['license_expiry_date'],
            'qualifications' => $step2['qualifications'],
            'years_of_experience' => $step2['years_of_experience'],
        ]);


        $user->assignRole('doctor');

        if ($request->hasFile('profile_image')) {
            $user->addMedia($request->file('profile_image'))->toMediaCollection('doctor-image');
        }

        

        // Clear session
        $request->session()->forget(['doctor_step1', 'doctor_step2']);

        return response()->json(['success' => true]);
    }




    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }



        
    public function edit(Doctor $doctor)
    {
        $genders = GenderEnums::cases();
        $relations = EmergencyContactRelationEnums::cases();
        $specializations = Specialization::all();
        return view('doctors.edit', compact('doctor', 'genders', 'relations', 'specializations'));
    }





    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $userId = $doctor->user_id;


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

            'primary_specialization_id' => 'required|exists:specializations,id',
            'secondary_specialization_id' => 'nullable|exists:specializations,id',
            'license_number' => 'required|string',
            'license_expiry_date' => 'required|date',
            'qualifications' => 'required|string',
            'years_of_experience' => 'required|integer',

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


        $doctor_data = collect($validatedData)->only(
            'primary_specialization_id',
            'secondary_specialization_id',
            'license_number',
            'license_expiry_date',
            'qualifications',
            'years_of_experience',
        )->toArray();


        $doctor->update($doctor_data);


        if ($request->hasFile('doctor_image'))
        {
            $user->clearMediaCollection('doctor-image');
            $user->addMedia($request->doctor_image)->toMediaCollection('doctor-image');
        }


        return redirect()->route('doctor.list')->with('success', 'Doctor Updated Successfully');

    }









    // Doctor Schedule Functions


    public function schedule($id)
    {
        $doctor = Doctor::with('schedules')->findOrFail($id);
        return view('doctors.schedule', compact('doctor'));
    }


    public function scheduleCreate(Doctor $doctor)
    {
        $existingDays = DoctorSchedule::where('doctor_id', $doctor->id)->pluck('day_of_week')->toArray();
        return view('doctors.scheduleCreate', compact('doctor', 'existingDays'));
    }


    public function scheduleStore(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|array',
            'day_of_week.*' => 'required|string|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:15',
            'is_available' => 'required|boolean'
        ]);

        // Create a record for each selected day
        foreach ($validated['day_of_week'] as $day) {
            DoctorSchedule::create([
                'doctor_id' => $validated['doctor_id'],
                'day_of_week' => $day,
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'duration' => $validated['duration'],
                'is_available' => $validated['is_available']
            ]);
        }
        

        return redirect()->route('doctor.schedule', $validated['doctor_id'])->with('success', 'Schedule created successfully.');
    }




    public function scheduleEdit(DoctorSchedule $schedule)
    {
        return view('doctors.scheduleEdit', compact('schedule'));
    }




    public function scheduleUpdate(Request $request, $id)
    {
        
        $request->merge([
        'start_time' => \Carbon\Carbon::parse($request->start_time)->format('H:i'),
        'end_time' => \Carbon\Carbon::parse($request->end_time)->format('H:i'),
     ]);


        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:15',
            'is_available' => 'required|boolean'
        ]);


        $schedule = DoctorSchedule::findOrFail($id);

        $schedule->update([
            'doctor_id' => $validated['doctor_id'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'duration' => $validated['duration'],
            'is_available' => $validated['is_available']
        ]);


        return redirect()->route('doctor.schedule', $validated['doctor_id'])->with('success', 'Schedule Updated successfully.');

    }



    public function scheduleDelete(DoctorSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'Schedule Deleted successfully.');
    }

}
