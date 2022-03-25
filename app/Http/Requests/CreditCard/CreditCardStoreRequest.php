<?php

namespace App\Http\Requests\CreditCard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreditCardStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'card_number' => ['required', 'string'],
            'holder' => ['required', 'string'],
            'expiration_date' => ['required', 'string'],
            'security_code' => ['required', 'string'],
            'brand' => ['required', 'string']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Invalid credit card',
            'data'      => $validator->errors()
        ], 400));
    }
}
