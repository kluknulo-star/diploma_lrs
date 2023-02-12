<?php

namespace App\Statements\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StatementApiRequestV2 extends FormRequest
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

    public function prepareForValidation()
    {

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '*.verb.id' => 'required|string',
            '*.actor.account.name' => 'required|string',
            '*.object.id' => 'required|string',
            '*' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
//        throw new HttpResponseException(response()->json([], 422));
    }
}
