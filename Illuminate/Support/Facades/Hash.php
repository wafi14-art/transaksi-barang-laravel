<?php

namespace Illuminate\Support\Facades;

class Hash
{
    public static function check(string $value, string $hashedValue): bool
    {
        if (function_exists('password_verify')) {
            return password_verify($value, $hashedValue);
        }

        return $value === $hashedValue;
    }
}
