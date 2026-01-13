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
        return [
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email,' . $this->user()->id,
        'phone'      => 'nullable|string|max:20',
        'password'   => 'nullable|confirmed|min:6',
        'profile_image' => 'nullable|image|max:2048',
     ];
    }


    public function authorize(): bool
    {
        return true;
    }

}
