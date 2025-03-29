<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\University;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::latest('published_at')->take(3)->get();
        $universities = University::orderBy('ranking', 'asc')->take(5)->get();
        
        return view('home', compact('news', 'universities'));
    }
}