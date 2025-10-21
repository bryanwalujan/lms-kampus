<?php
// app/Http/Requests/ProfileUpdateRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['email', 'max:255', 'required'],
            'phone' => ['nullable', 'string', 'max:20'],
            'nim_nidn' => ['nullable', 'string', 'max:20'],
            'department' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'bio' => ['nullable', 'string'],
        ];
    }
}