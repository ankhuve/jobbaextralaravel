<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Carbon\Carbon;

class ValidateNewJob extends Request
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
            'title' => 'required|max:60',
            'work_place' => 'required',
            'type' => 'required',
            'county' => 'required',
            'municipality' => 'required',
            'description' => 'required',
            'latest_application_date' => 'after:'.Carbon::today()->format('Y-m-d'),
            'contact_email' => 'required|email',
        ];
    }
}
