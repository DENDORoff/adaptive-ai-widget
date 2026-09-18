<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ValidEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('Неверный формат email адреса.');
            return;
        }


        $disposableDomains = [
            'tempmail.com', 'guerrillamail.com', '10minutemail.com',
            'throwaway.email', 'temp-mail.org', 'mailinator.com',
        ];

        $domain = substr(strrchr($value, "@"), 1);
        if (in_array($domain, $disposableDomains)) {
            $fail('Использование одноразовых email запрещено.');
        }
    }
}