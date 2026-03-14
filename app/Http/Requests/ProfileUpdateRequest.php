<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        $user = $this->user();

        if ($user->user_type === 'donor') {
            $rules['phone'] = ['nullable', 'string', 'max:20'];
            $rules['address'] = ['nullable', 'string', 'max:500'];
        }

        if ($user->user_type === 'ngo') {
            $rules['organization_name'] = ['required', 'string', 'max:255'];
            $rules['address'] = ['required', 'string', 'max:500'];
            $rules['contact_person'] = ['required', 'string', 'max:255'];
            $rules['phone'] = ['required', 'string', 'max:20'];
        }

        if ($user->user_type === 'user') {
            $rules['phone'] = ['required', 'string', 'max:20'];
            $rules['location'] = ['required', 'string', 'max:255'];
            $rules['need_category'] = ['nullable', 'in:education,healthcare,shelter,food,clothing,emergency,other'];
            $rules['description'] = ['nullable', 'string', 'max:1000'];
        }

        return $rules;
    }
}
