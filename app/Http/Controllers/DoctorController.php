<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(){
        return response()->json(Doctor::get());
    }
}
