<?php

namespace App\Rules;

use App\Models\UsersVolunteerRequest;
use Illuminate\Contracts\Validation\Rule;

class CheckTheRequestAvailability implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $status = UsersVolunteerRequest::firstWhere('id' , '=' ,  $value)->status;

        if($status == 'accepted'){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This trip is currently assigned to another volunteer';
    }
}
