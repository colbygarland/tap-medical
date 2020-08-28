<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\GetAppointmentsRequest;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function get(GetAppointmentsRequest $request){
        $appointments = Appointment::where('doctor_id', $request->doctor_id)
            ->where('created_at', $request->date)
            ->get();

        $response = [
            'message' => 'Appointments retrieved.',
            'appointments' => $appointments,
        ];
        return response()->json($response);
    }
}
