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
            'title' => 'required|max:60|string',
            'work_place' => 'required|string',
            'type' => 'required|integer',
            'county' => 'required',
            'municipality' => 'required|string',
            'description' => 'required|string',
            'latest_application_date' => 'after:'.Carbon::today()->format('Y-m-d'),
            'contact_email' => 'required|email',
            'external_link' => 'url',
        ];
    }
}
