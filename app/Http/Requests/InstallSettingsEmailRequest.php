<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class InstallSettingsEmailRequest extends FormRequest
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
            'email_driver' => 'required',
            'email_host' => 'required_if:email_driver,smtp',
            'email_port' => 'required_if:email_driver,smtp',
            'email_username' => 'required_if:email_driver,smtp',
            'email_password' => 'required_if:email_driver,smtp',
            'ses_key' => 'required_if:email_driver,ses',
            'ses_secret' => 'required_if:email_driver,ses',
            'ses_region' => 'required_if:email_driver,ses',
            'mailgun_domain' => 'required_if:email_driver,mailgun',
            'mailgun_secret' => 'required_if:email_driver,mailgun',
        ];
    }
}
