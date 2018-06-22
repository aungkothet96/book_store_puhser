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
            // $check_result = file_get_contents("https://api.trumail.io/v2/lookups/json?email=". $value ."&token=608e1ffc-e00d-4b96-9c50-d49e13973536");
            // $check_result = json_decode({'address':'aungko1@ucsy.edu.mm','username':'aungko1','domain':'ucsy.edu.mm','md5Hash':'322c5078465eedb94c12eb6c246bb8fc','validFormat':true,'deliverable':false,'fullInbox':false,'hostExists':true,'catchAll':false,'gravatar':false,'role':false,'disposable':false,'free':false}");
            // $check_result = file_get_contents("https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json");
            // dd($check_result);
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
