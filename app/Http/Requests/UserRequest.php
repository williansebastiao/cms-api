<?php

namespace App\Http\Requests;

use App\Constants\ApiStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest {

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
                'first_name' => 'required|min:2',
                'last_name' => 'required|min:2',
                'email' => 'email|unique:users,email',
                'password' => 'required|min:8',
            ];
        } else if (in_array('update', $segments)) {
            //$user = auth()->user();
            return [
                'first_name' => 'required|min:2',
                'last_name' => 'required|min:2',
                'email' => 'email',
                //'email' => 'email', Rule::unique('users')->ignore($user->id),
            ];
        } else {
            return [
                'first_name' => 'required|min:2',
                'last_name' => 'required|min:2',
                'email' => 'email|unique:users,email',
                'password' => 'required|min:8',
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
