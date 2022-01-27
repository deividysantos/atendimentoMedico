<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules;

class RegisterDoctorRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'documentMedical_id' => ['required', 'unique:doctors', 'string'],
            'email' => ['required', 'string','email', 'max:255', 'unique:doctors'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
           'message' => 'Invalid data send',
           'details' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
