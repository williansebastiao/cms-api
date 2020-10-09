<?php

namespace App\Http\Requests;

use App\Constants\ApiStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $segments = $this->segments();
        if(in_array('store', $segments)) {
            return [
                'name' => 'required|min:2',
                'email' => 'email|unique:administrators,email',
                'cnpj' => 'required|cnpj',
                //'password' => 'required|min:8',
                //'role' => 'required'
            ];
        } else if (in_array('update', $segments)) {
            $user = auth('client')->user();
            return [
                'name' => 'required|min:2',
                'email' => 'email', Rule::unique('clients')->ignore($user->id),
                //'cnpj' => 'required|cnpj',
                //'password' => 'required|min:8',
                //'role' => 'required'
            ];
        } else {
            $user = auth('administrator')->user();
            return [
                'first_name' => 'required|min:4',
                'last_name' => 'required|min:4',
                'email' => 'email', Rule::unique('administrators')->ignore($user->id),
            ];
        }
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['message' => $validator->errors()->first()], ApiStatus::unprocessableEntity));
    }

    /**
     * @return array
     */
    public function attributes(){
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'role' => 'permissão',
        ];
    }
}
