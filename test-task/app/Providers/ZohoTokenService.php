<?php

namespace App\Providers;

use App\Models\ZohoToken;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ZohoTokenService
{
    private $clientId;
    private $clientSecret;
    private $refreshToken;
    private $authUrl;

    public function __construct()
    {
        $this->clientId = config('services.zoho.client_id');
        $this->clientSecret = config('services.zoho.client_secret');
        $this->refreshToken = ZohoToken::first()->refresh_token ?? null;
        $this->authUrl = 'https://accounts.zoho.com/oauth/v2/token';
    }

    public function getAccessToken()
    {
        $token = ZohoToken::first();

        // Перевірка чи токен активний
        if ($token && Carbon::now()->lt(Carbon::parse($token->expires_at))) {
            return $token->access_token;
        }

        // Оновлення токену
        return $this->refreshAccessToken();
    }

    public function refreshAccessToken()
    {
        if (!$this->refreshToken) {
            throw new \Exception('Refresh token not found.');
        }

        $response = Http::asForm()->post($this->authUrl, [
            'refresh_token' => $this->refreshToken,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to refresh access token: ' . $response->body());
        }

        $data = $response->json();

        // Збереження нового токену
        $token = ZohoToken::firstOrNew([]);
        $token->access_token = $data['access_token'];
        $token->refresh_token = $this->refreshToken;
        $token->expires_at = Carbon::now()->addSeconds($data['expires_in']);
        $token->save();

        return $token->access_token;
    }
}
