<?php

namespace App\Rules;

use App\InvalidEmail;
use Illuminate\Contracts\Validation\Rule;

class NotExist implements Rule
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
        $invalidEmail =  InvalidEmail::where('email',$value)->first();
        if ($invalidEmail) {
            return false;
        } else {
            //need to check with https://trumail.io
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your Email does not exist. Try another Email.!!';
    }
}
