<?php

namespace App\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[a-zA-Zа-яА-Я.\s-]{2,60}$/',
            'email' => 'required|min:6|max:100|email|' . Rule::unique('users')
                    ->ignore($this->route('id'), 'user_id')
        ];
    }
}
