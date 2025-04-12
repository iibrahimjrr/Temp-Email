<?php

namespace App\Http\Controllers;

use App\Models\TemporaryEmail;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class TemporaryEmailController extends Controller
{
    public function generate(Request $request)
    {
        $fristpart = str::random(6);
        $secondpart = rand(1,1000);
        $domain = 'ibrahim.com';
        $email = $fristpart . $secondpart . '@' . $domain;

        $tempEmail = new TemporaryEmail();
        $tempEmail->email = $email;
        $tempEmail->expires_at = now()->addHours(1);
        $tempEmail->save();

        return redirect()->route('home')->with('email', $email);
    }

    public function inbox($email)
    {
        try {
            $messages = $this->getMessagesFromMailhog($email);

            return view('inbox', [
                'email'    => $email,
                'messages' => $messages,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Failed to fetch inbox',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    private function getMessagesFromMailhog($email)
    {
        $client = new Client();
        $response = $client->get('http://localhost:8025/api/v2/messages');
        $data = json_decode($response->getBody(), true);

        $filtered = [];

        foreach ($data['items'] as $item) {
            $toList = array_column($item['Content']['Headers']['To'], 0);

            foreach ($toList as $to) {
                if (stripos($to, $email) !== false) {
                    $filtered[] = [
                        'subject' => $item['Content']['Headers']['Subject'][0] ?? '(No Subject)',
                        'from'    => $item['Content']['Headers']['From'][0] ?? '(Unknown)',
                        'body'    => $item['Content']['Body'] ?? '',
                        'date'    => $item['Created'],
                    ];
                }
            }
        }

        return $filtered;
    }
}
