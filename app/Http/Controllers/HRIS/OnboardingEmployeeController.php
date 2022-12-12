<?php

namespace App\Http\Controllers\HRIS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnboardingEmployeeController extends Controller
{
    public function index()
    {
        return view('backend.hris.employee.onboarding-employee-list');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
