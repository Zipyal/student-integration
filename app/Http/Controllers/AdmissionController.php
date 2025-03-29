<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        return view('admission.index');
    }

    public function requirements()
    {
        return view('admission.requirements');
    }

    public function documents()
    {
        return view('admission.documents');
    }

    public function deadlines()
    {
        return view('admission.deadlines');
    }
}