<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::guard('student')->user();
        return view('students.dashboard', compact('student'));
    }

    public function schedule()
    {
        $student = Auth::guard('student')->user();
        return view('students.schedule', compact('student'));
    }

    public function documents()
    {
        $student = Auth::guard('student')->user();
        return view('students.documents', compact('student'));
    }

    public function support()
    {
        return view('students.support');
    }
}