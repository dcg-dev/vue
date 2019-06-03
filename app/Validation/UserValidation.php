<?php

namespace App\Validation;

use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserValidation extends Validator
{

    /**
     * Check if old password is the same as new one.
     * It's for updating profile settings.
     *
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return boolean
     */
    public function validateOldPassword($attribute, $value, $parameters)
    {
        $user = Auth::user();
        //if user was registered through facebook, and has empty password
        return Auth::user()->is_empty_password ? true : Hash::check($value, $user->password);
    }

    /**
     * Check slug
     *
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return boolean
     */
    public function validateSlug($attribute, $value, $parameters)
    {
        return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value);
    }


    public function validateCewl($attribute, $value)
    {
        $provider = explode('@', $value)[1];
        $settigns = explode("\n", \Setting::get('firewall.cewl'));
        if ($settigns) {
            foreach ($settigns as $settign) {
                if (strpos(trim($settign), $provider) === true) {
                    return false;
                }
            }
        }
        $handle = @fopen(__DIR__ . "/disposable_email_blacklist.conf", "r");
        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle);
                if (strpos($buffer, $provider) === true) {
                    return false;
                }
            }
            fclose($handle);
        }
        return true;
    }
}
