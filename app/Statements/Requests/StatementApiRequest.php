<?php

namespace App\Statements\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StatementApiRequest extends FormRequest
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
            'verb' => ['required', 'array'],
            'verb.id' => ['required', 'string'],

            'actor' => ['required', 'array'],
            'actor.mbox' => ['required', 'string'],

            'object' => ['required', 'array'],
            'object.id' => ['required', 'string'],
            'object.type' => ['nullable', 'string'],

            'context' => ['nullable', 'array'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}
