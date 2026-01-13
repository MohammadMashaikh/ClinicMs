<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {

        $user = auth()->user();

        if ($user->hasRole('super-admin')) {
            return $this->superAdminDashboard();
        } elseif ($user->hasRole('doctor')) {
            return $this->doctorDashboard();
        } elseif ($user->hasRole('patient')) {
            return $this->patientDashboard();
        }

        abort(403, 'Unauthorized');
    }



    public function superAdminDashboard()
    {
         // Super Admin Dashboard
        $today = Carbon::today();

        $recentAppointments  = Appointment::latest()->take(3)->get();
        $todayAppointments = Appointment::whereDate('date', $today)->count();
        $totalAppointments = Appointment::count();
        
        $totalPatients = Patient::count();

        $totalDoctors = Doctor::count();
        $totalPharmacy = User::role('pharmacy')->count();
        $totalReceptionist = User::role('receptionist')->count();
        $totalStaff = $totalDoctors + $totalPharmacy + $totalReceptionist;

        $medicinesStatus = Pharmacy::query();

        $inStock = (clone $medicinesStatus)->whereColumn('quantity', '>', 'reorder_level')->count();

        $lowStock = (clone $medicinesStatus)->where('quantity', '>', 0)->whereColumn('quantity', '<=', 'reorder_level')->count();

        $outOfStock = (clone $medicinesStatus)->where('quantity', '=', 0)->count();

         return view('dashboard', compact(
            'recentAppointments',
            'todayAppointments',
            'totalAppointments',
            'totalPatients',
            'totalDoctors',
            'totalPharmacy',
            'totalReceptionist',
            'totalStaff',
            'outOfStock',
            'inStock',
            'lowStock',
        ));
    }




    public function doctorDashboard()
    {
        $user = auth()->user();
        $doctorId = $user->doctor->id;
        $today = Carbon::today();

        $doctorTotalAppointments = Appointment::where('doctor_id', $doctorId)->count();
        $doctorPendingAppointments = Appointment::where('doctor_id', $doctorId)->where('status', 'Pending')->count();
        $doctorTodaySchedule = Appointment::where('doctor_id', $doctorId)->whereDate('date', $today)->get();
        
        $doctorUpComingSchedule = Appointment::where('doctor_id', $doctorId)->whereDate('date', '>', $today)->get();
        $doctorSchedule = Doctor::with('schedules')->findOrFail($doctorId);

        return view('dashboard', compact('doctorTotalAppointments','doctorPendingAppointments','doctorTodaySchedule','doctorUpComingSchedule','doctorSchedule'));
    }





    public function patientDashboard()
    {
        $user = Auth::user();

        $patient = $user->patient;
        $today = Carbon::today();

        $appointments = Appointment::with('doctor.user')->where('patient_id', $patient->id)->orderBy('date', 'desc')->get();

        $patientTotalAppointments = $appointments->count();
        $patientUpcomingAppointments = $appointments->whereIn('status', ['Pending', 'In Progress', 'Confirmed'])->where('date', '>', $today)->count();
        $patientCompletedAppointments = $appointments->where('status', 'Completed')->count();
        $patientCancelledAppointments = $appointments->where('status', 'Cancelled')->count();

        $patientUpcoming = $appointments->whereIn('status', ['Pending', 'Confirmed'])->where('date', '>=', Carbon::today())->sortBy('date')->take(5);

        $patientHistory = $appointments->where('date', '<', Carbon::today())->sortByDesc('date')->take(5);

        $patientDoctor = $appointments->where('status', 'Confirmed')->first()->doctor ?? null;

        return view('dashboard', compact('patientTotalAppointments', 'patientUpcomingAppointments', 'patientCompletedAppointments',
            'patientCancelledAppointments',
            'patientUpcoming',
            'patientHistory',
            'patientDoctor'
        ));
    }

}
