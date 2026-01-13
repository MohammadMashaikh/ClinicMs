<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    

    public function pdfCourses()
    {
        $courses = Course::with(['instructor', 'students', 'category', 'assignments'])->withCount('students')->get();

        $pdf = Pdf::loadView('pdf.courses', compact('courses'));
        
        return $pdf->stream('courses.pdf');
    }



    public function pdfInstructors()
    {
        $instructors = User::role('instructor')->with('coursesTaught', 'category')->get();

        $pdf = Pdf::loadView('pdf.instructors', compact('instructors'));
        
        return $pdf->stream('instructors.pdf');
    }



    public function pdfAssignments()
    {
        $assignments = Assignment::with('course', 'course.instructor', 'course.students')->get();

        $pdf = Pdf::loadView('pdf.assignments', compact('assignments'));
        
        return $pdf->stream('assignments.pdf');
    }

}
