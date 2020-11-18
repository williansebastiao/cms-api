<?php

namespace App\Http\Requests;

use App\Constants\ApiStatus;
use App\Rules\Cellphone;
use App\Rules\Zipcode;
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
        } else if(in_array('personal', $segments)) {
            return [
                'site' => 'required|url',
                'phone' => ['required', new Cellphone()],
                'address.zipcode' => ['required', new Zipcode()],
                'address.street' => 'required|min:4',
                'address.number' => 'required|min:1|max:6',
                'address.neighborhood' => 'required|min:2|max:10',
                'address.state' => 'required|min:2|max:2',
                'address.city' => 'required|min:2|max:20',
            ];
        } else if(in_array('password', $segments)) {
            return [
                'old_password' => 'required|min:8',
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8|same:password',
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
            'first_name' => 'primeiro nome',
            'last_name' => 'sobrenome',
            'email' => 'e-mail',
            'permission' => 'permissão',
            'address.zipcode' => 'cep',
            'address.street' => 'enderećo',
            'address.number' => 'número',
            'address.neighborhood' => 'bairro',
            'address.state' => 'estado',
            'address.city' => 'cidade',
            'old_password' => 'senha antiga',
            'password' => 'senha',
            'confirm_password' => 'confirmar senha'
        ];
    }
}
