<?php

namespace App\Http\Requests\User;

use App\Http\Helpers\APIHelpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class SignInValidation extends FormRequest
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
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;

        $message = "Validation Failed!";

        $response = APIHelpers::createAPIResponse(true, $code, $message, $validator->errors());

        throw new HttpResponseException(\response($response, Response::HTTP_OK));
    }
}
