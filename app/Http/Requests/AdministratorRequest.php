<?php

namespace App\Http\Requests;

use App\Constants\ApiStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AdministratorRequest extends FormRequest
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
                'first_name' => 'required|min:4',
                'last_name' => 'required|min:4',
                'email' => 'email|unique:administrators,email',
                'password' => 'required|min:8',
                'role' => 'required'
            ];
        } else if (in_array('update', $segments)) {
            $user = auth('administrator')->user();
            return [
                'first_name' => 'required|min:4',
                'last_name' => 'required|min:4',
                'email' => 'email', Rule::unique('administrators')->ignore($user->id),
                'role' => 'required'
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
            'first_name' => 'nome',
            'last_name' => 'sobrenome',
            'email' => 'e-mail',
            'role' => 'permissão',
        ];
    }
}
