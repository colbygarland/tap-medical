<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class GetAppointmentsRequest
 * @package App\Http\Requests
 * @property int doctor_id
 * @property Carbon date
 */
class GetAppointmentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctor_id' => ['required', 'int', Rule::exists('doctors', 'id')],
            'date' => ['required', 'date'],
        ];
    }
}
