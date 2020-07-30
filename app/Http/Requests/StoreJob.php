<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJob extends FormRequest
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

            'agent_id' => 'required',
            'contract_id' => 'required',
            'frequency_id' => 'required',
            'status_id' => 'required',
            'job_number' => 'required',
            'job_name' => 'required',
            'job_floors' => 'required',
            'job_address' => 'required',
            'job_address_number' => 'required',
            'job_suburb' => 'required',
            'job_contact_details' => 'required',
            'job_email' => 'required',
            'job_owner_details' => 'required',
            'job_group' => 'required',
            'round_id' => 'required',
            'job_agent_contact' => 'required',
            'job_key_access' => 'required'
        ];
    }
}
