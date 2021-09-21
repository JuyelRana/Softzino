<?php

namespace App\Http\Requests\User;

use App\Http\Helpers\APIHelpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SignUpValidation extends FormRequest
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

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($this->getMethod() === 'POST') {
            $rules += [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ];
        } else {
            $rules += [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'sometimes',
                    Rule::unique('users', 'email')->ignore(request()->route('user'))
                ],
                'birthdate' => ['required']
            ];
        }

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;

        $message = "Validation Failed!";

        $response = APIHelpers::createAPIResponse(true, $code, $message, $validator->errors());

        throw new HttpResponseException(\response($response, Response::HTTP_OK));
    }
}
