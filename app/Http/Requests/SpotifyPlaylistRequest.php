<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpotifyPlaylistRequest extends FormRequest
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
            'name' => 'nullable|string',
            'spotify_account_id' => 'required|string',
            'spotify_playlist_id' => 'required|alpha_num'
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
            'spotify_account_id.required' => 'Give the Account ID.',
            'spotify_playlist_id.required' => 'Give the Playlist ID.'
        ];
    }
}
