<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SyrianPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^09\d{8}$/', $value)) {
            $fail("يجب أن يكون رقم الهاتف رقم هاتف سوري (يبدأ بـ 09 و يتألف من عشر أرقام)");
        }
    }
}
