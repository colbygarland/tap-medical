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

    protected $appends = [
        'specialty_name',
        'status',
    ];

    public function getSpecialtyNameAttribute(){
        $s = Specialty::find($this->specialty_id);
        return $s->name;
    }

    public function getStatusAttribute(){
        if($this->cancelled) return 'Cancelled';
        if(Carbon::parse($this->start_date)->isPast()) return 'Passed';
        return 'Upcoming';
    }

    private static function xmlToJson(string $xml_string){
        return simplexml_load_string($xml_string);
    }

    private static function addAppointment($appointment){
        $age_of_patient = Carbon::parse($appointment->patient->date_of_birth ?? $appointment->patient->dob)
            ->diff(Carbon::now())->y;
        if($age_of_patient > Patient::MAX_AGE) return null;

        $start_date = Carbon::parse($appointment->start_date ?? $appointment->datetime)->diff(Carbon::now())->m;
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
            'sex' => $appointment->patient->sex ?? null,
            'gender' => $appointment->patient->gender ?? null,
            'date_of_birth' => $appointment->patient->date_of_birth ?? $appointment->patient->dob,
        ]);
        $patient->save();


        $a = Appointment::firstOrNew([
            'clinic_id' => $clinic->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'specialty_id' => $specialty->id,
        ], [
            'id' => $appointment->id,
            'cancelled' => $cancelled ?? false,
            'start_date' => Carbon::parse($appointment->start_date ?? $appointment->datetime)->toDateString(),
            'start_time' => Carbon::parse($appointment->start_time ?? $appointment->datetime)->toTimeString(),
            'booked_at' => Carbon::parse($appointment->booked_at ?? $appointment->created_at),
        ]);
        $a->save();

        return $a;
    }

    public static function refreshAppointments(){
        self::clinicOne();
        self::clinicTwo();
    }

    public static function clinicOne(){
        // Get the appointments and convert to json
        $xml_string = Http::withBasicAuth('Myah', '654321')
            ->get(config('app.api_endpoint'). 'xml', ['from' => Carbon::now()->addMonth()->toDateTimeString()]);
        $json = self::xmlToJson($xml_string);

        $appointments = [];
        foreach($json->appointment as $appointment){
            $a = self::addAppointment($appointment);
            if(! is_null($a)) $appointments[] = $a;
        }

        return $appointments;
    }

    public static function clinicTwo(){
        // Get the token
        $token = Http::post(config('app.api_endpoint') . 'auth', [
            'email' => 'zlindgren@yahoo.com',
            'password' => 'Tap!M3d1cal',
        ])['token'];
        $response = Http::withToken($token)->get(config('app.api_endpoint'). 'json', [
            'page' => 1,
        ])->object()->data;

        $appointments = [];
        foreach($response as $appointment){
            $a = self::addAppointment($appointment);
            if(! is_null($a)) $appointments[] = $a;
        }

        return $appointments;
    }

}
