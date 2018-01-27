<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpotifyAccountRequest extends FormRequest
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
            'name' => 'required|string',
            'spotify_account_id' => 'required|string',
        ];
    }

    /**
     * Get the error messages associated with validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Give this Account a name.',
            'spotify_account_id.required' => 'Give this Account a relevant ID.'
        ];
    }
}
