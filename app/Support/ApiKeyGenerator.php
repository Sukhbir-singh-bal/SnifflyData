<?php

namespace App\Support;

use App\Models\ApiKey;
use Illuminate\Support\Str;

class ApiKeyGenerator
{
    /**
     * @return array{plain: string, hash: string, last4: string}
     */
    public static function generate(): array
    {
        do {
            $plain = 'sk_live_'.Str::random(48);
            $hash = hash('sha256', $plain);
        } while (ApiKey::query()->where('key_hash', $hash)->exists());

        return [
            'plain' => $plain,
            'hash' => $hash,
            'last4' => substr($plain, -4),
        ];
    }
}
