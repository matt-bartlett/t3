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
            'spotify_user_id' => 'required',
            'spotify_playlist_id' => 'required'
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
            'spotify_user_id.required' => 'Please specify the User ID associated with the Playlist.',
            'spotify_playlist_id.required' => 'Please specify the Playlist ID.'
        ];
    }
}