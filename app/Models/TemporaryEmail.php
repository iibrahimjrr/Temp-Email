<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TemporaryEmail extends Model
{
    protected $fillable = ['email', 'expires_at'];

    public static function generate()
    {
        $localPart = Str::random(10); 
        $domain    = 'shtey-digital.test';
        $email     = $localPart . '@' . $domain;

        return self::create([
            'email'      => $email,
            'expires_at' => now()->addMinutes(10),
        ]);
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}

