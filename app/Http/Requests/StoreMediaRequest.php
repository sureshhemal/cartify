<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'required|file|max:2048',
        ];
    }
}
