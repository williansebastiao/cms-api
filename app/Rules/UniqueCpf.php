<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueCpf implements Rule {

    protected $data;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model) {
        $this->data = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $cpf = clearSpecialCharacters($value);
        $query = $this->data::where('cpf', $cpf)->count();
        if($query > 0){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return 'CPF já existe na base de dados';
    }
}
