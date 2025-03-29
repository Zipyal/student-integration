<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,teacher',
            'phone' => 'required|string|max:20',
        ];

        if ($data['role'] === 'student') {
            $rules['country'] = 'required|string|max:100';
            $rules['university_id'] = 'required|exists:universities,id';
        }

        return Validator::make($data, $rules);
    }

    protected function create(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone' => $data['phone'],
        ];

        if ($data['role'] === 'student') {
            $userData['country'] = $data['country'];
            $userData['university_id'] = $data['university_id'];
            $userData['status'] = 'active';
        }

        return User::create($userData);
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'universities' => University::all(),
            'roles' => [
                'student' => 'Студент',
                'teacher' => 'Преподаватель'
            ]
        ]);
    }

    public function redirectTo()
    {
        if (auth()->user()->isAdmin()) {
            return '/admin/dashboard';
        }
        
        if (auth()->user()->isTeacher()) {
            return '/teacher/dashboard';
        }
        
        return '/student/dashboard';
    }
}