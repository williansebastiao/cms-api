<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
                'role_id' => 'required|integer'
            ];
        } else if (in_array('update', $segments)) {
            $user = auth('administrator')->user();
            return [
                'first_name' => 'required|min:4',
                'last_name' => 'required|min:4',
                'email' => 'email', Rule::unique('administrators')->ignore($user->id),
                'role_id' => 'required|integer'
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
}
