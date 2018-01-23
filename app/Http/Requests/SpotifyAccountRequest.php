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
            'spotify_user_id' => 'required|alpha_num',
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
            'name.required' => 'Please specify a display name for the Spotify user',
            'spotify_user_id.required' => 'Please specify the Spotify ID'
        ];
    }
}
