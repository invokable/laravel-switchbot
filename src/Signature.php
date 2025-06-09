<?php

namespace Revolution\SwitchBot;

use Illuminate\Support\Str;

class Signature
{
    public static function make(string $token, string $secret, string $t, string $nonce): string
    {
        return Str::of(hash_hmac('sha256', $token.$t.$nonce, $secret, true))
            ->pipe('base64_encode')
            ->upper()
            ->value();
    }
}
