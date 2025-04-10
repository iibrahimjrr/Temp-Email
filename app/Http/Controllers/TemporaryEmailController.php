<?php

namespace App\Http\Controllers;

use App\Models\TemporaryEmail;

class TemporaryEmailController extends Controller
{
    public function generate()
    {
        $tempEmail = TemporaryEmail::generate();

        return response()->json([
            'email' => $tempEmail->email,
            'expires_at' => $tempEmail->expires_at->toDateTimeString(),
        ]);
    }
}

