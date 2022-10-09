<?php

namespace Revolution\SwitchBot;

use Illuminate\Support\Str;

class Signature
{
    public static function make(string $token, string $secret, string $t, string $nonce): string
    {
        return Str::upper(base64_encode(hash_hmac('sha256', $token.$t.$nonce, $secret, true)));
    }
}
