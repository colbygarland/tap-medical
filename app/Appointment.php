<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Http;

/**
 * Class Appointment
 * @package App
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    protected $fillable = [
        'id', 'clinic_id', 'doctor_id', 'patient_id', 'specialty_id', 'cancelled', 'start_date', 'start_time',
        'booked_at', 'created_at', 'updated_at',
    ];

    private static function xmlToJson(string $xml_string){
        return simplexml_load_string($xml_string);
    }

    private static function addAppointment($appointment){
        $age_of_patient = Carbon::parse($appointment->patient->date_of_birth)->diff(Carbon::now())->y;
        if($age_of_patient > Patient::MAX_AGE) return null;

        $start_date = Carbon::parse($appointment->start_date)->diff(Carbon::now())->m;
        if($start_date > 1) return null;

        $clinic = Clinic::firstOrNew(['id' => $appointment->clinic->id], [
            'name' => $appointment->clinic->name,
            'auth_type' => 'Basic',
        ]);
        $clinic->save();
        $doctor = Doctor::firstOrNew(['id' => $appointment->doctor->id], [
            'name' => $appointment->doctor->name,
        ]);
        $doctor->save();
        $specialty = Specialty::firstOrNew(['id' => $appointment->specialty->id], [
            'name' => $appointment->specialty->name,
        ]);
        $specialty->save();
        $patient = Patient::firstOrNew(['id' => $appointment->patient->id], [
            'name' => $appointment->patient->name,
            'sex' => $appointment->patient->sex,
            'date_of_birth' => $appointment->patient->date_of_birth,
        ]);
        $patient->save();

        if($appointment->cancelled == 1) $cancelled = true;
        else $cancelled = false;
        $a = Appointment::firstOrNew([
            'clinic_id' => $clinic->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'specialty_id' => $specialty->id,
        ], [
            'id' => $appointment->id,
            'cancelled' => $cancelled,
            'start_date' => Carbon::parse($appointment->start_date)->toDateString(),
            'start_time' => Carbon::parse($appointment->start_time)->toTimeString(),
            'booked_at' => Carbon::parse($appointment->booked_at),
        ]);
        $a->save();
    }

    public static function clinicOne(){
        // Get the appointments and convert to json
        $xml_string = Http::withBasicAuth('Myah', '654321')
            ->get('http://ch-api-test.herokuapp.com/xml', ['from' => Carbon::now()->addMonth()->toDateTimeString()]);
        $json = self::xmlToJson($xml_string);

        $appointments = [];
        foreach($json->appointment as $appointment){
            $a = self::addAppointment($appointment);
            if(! is_null($a)) $appointments[] = $a;
        }

        return $appointments;
    }

    public static function clinicTwo(){

    }

}
