<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\ZohoTokenService;

class RefreshZohoToken extends Command
{
    protected $signature = 'zoho:refresh-token';
    protected $description = 'Refresh Zoho API token';

    private $zohoTokenService;

    public function __construct(ZohoTokenService $zohoTokenService)
    {
        parent::__construct();
        $this->zohoTokenService = $zohoTokenService;
    }

    public function handle()
    {
        try {
            $accessToken = $this->zohoTokenService->refreshAccessToken();
            $this->info("Access token refreshed successfully: $accessToken");
        } catch (\Exception $e) {
            $this->error('Failed to refresh token: ' . $e->getMessage());
        }
    }
}

