<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cellphone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $exp_regular = '/^\([1-9]{2}\) [2-9][0-9]{4}\-[0-9]{4}$/';
        $match = preg_match($exp_regular, $value);

        if($match === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo :attribute está incorreto!';
    }
}
