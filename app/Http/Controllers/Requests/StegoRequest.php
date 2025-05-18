<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StegoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'required|image|max:5120', // 5MB max
            'message' => 'required|string|max:256',
            'method' => 'required|in:lsb,gan'
        ];
    }

    public function messages()
    {
        return [
            'image.max' => 'The image must not be larger than 5MB.',
            'message.max' => 'The message must not exceed 256 characters.',
            'method.in' => 'Please select a valid steganography method.'
        ];
    }

    public function authorize()
    {
        return true;
    }
}