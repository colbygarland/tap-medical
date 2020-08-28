<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Check and ensure we have run the appointment scraper at least once
        if(! Appointment::first()){
            Appointment::refreshAppointments();
        }
        return view('home');
    }
}
