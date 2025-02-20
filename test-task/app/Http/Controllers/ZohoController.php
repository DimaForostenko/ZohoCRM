<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZohoController extends Controller
{
    private $authToken;

    public function __construct()
    {
        $this->authToken = $this->getAuthToken(); // Отримання або оновлення токену
    }

    public function createRecords(Request $request)
    {
        $validated = $request->validate([
            'dealName' => 'required|string',
            'dealStage' => 'required|string',
            'accountName' => 'required|string',
            'accountWebsite' => 'required|url',
            'accountPhone' => 'required|string',
        ]);

        try {
            // Створення облікового запису
            $accountResponse = Http::withToken($this->authToken)
                ->post('https://www.zohoapis.com/crm/v2/Accounts', [
                    'data' => [
                        [
                            'Account_Name' => $validated['accountName'],
                            'Website' => $validated['accountWebsite'],
                            'Phone' => $validated['accountPhone'],
                        ],
                    ],
                ]);

            $accountId = $accountResponse['data'][0]['id'] ?? null;

            if (!$accountId) {
                return response()->json(['message' => 'Failed to create account.'], 400);
            }

            // Створення угоди
            $dealResponse = Http::withToken($this->authToken)
                ->post('https://www.zohoapis.com/crm/v2/Deals', [
                    'data' => [
                        [
                            'Deal_Name' => $validated['dealName'],
                            'Stage' => $validated['dealStage'],
                            'Account_Name' => ['id' => $accountId],
                        ],
                    ],
                ]);

            return response()->json(['message' => 'Records created successfully!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    private function getAuthToken()
    {
        // Реалізація механізму отримання/оновлення токену
        return 'YOUR_ZOHO_AUTH_TOKEN';
    }
}
