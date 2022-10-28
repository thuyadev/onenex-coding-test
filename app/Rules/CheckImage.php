<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class CheckImage implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        // allow extensions
        $allow = ['png', 'jpg', 'jpeg', 'svg'];

        if (!is_file($value))
        {
            $explode = explode(',', $value);
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );

            // check file format
            if (!in_array($format, $allow)) {
                $fail('The :attribute must be valid image file or base64 format.');
            }

            // check base64 format
            if (!isset($explode[1]) || !preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                $fail('The :attribute must be valid image file or base64 format.');
            }
        }
        else
        {
            if (!in_array($value->getClientOriginalExtension(), $allow))
            {
                $fail('The :attribute must be valid image file or base64 format.');
            }
        }
    }
}
