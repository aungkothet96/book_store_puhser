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
            $check_result =json_decode(file_get_contents("https://api.trumail.io/v2/lookups/json?email=". $value ."&token=608e1ffc-e00d-4b96-9c50-d49e13973536"));
            if ($check_result->deliverable) {
                return true;
            } else {
                InvalidEmail::create(['email' => $value,]);
                return false;
            }
           
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
