<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\GetAppointmentsRequest;
use Session;

class AppointmentController extends Controller
{
    public function pull(){
        $response = [
            'clinicOne' => Appointment::clinicOne(),
            'clinicTwo' => Appointment::clinicTwo(),
        ];
        return response()->json($response);
    }

    /**
     * Get a list of appointments filtered by doctor and date.
     *
     * @param GetAppointmentsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function find(GetAppointmentsRequest $request){
        $appointments = Appointment::where('doctor_id', $request->doctor_id)
            ->where('start_date', $request->date)
            ->get();

        Session::flash('appointments', $appointments);
        Session::flash('doctor_id', $request->doctor_id);
        Session::flash('date', $request->date);
        return back()->with(['success' => 'Appointments retrieved.']);
    }
}
