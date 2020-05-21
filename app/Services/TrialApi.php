<?php declare(strict_types = 1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TrialApi
{

    public function __construct()
    {
        $this->baseUrl = config('services.api.base');
    }

    /**
     * @param int $page
     * @return array
     */
    public function getProperties(int $page = 1): array
    {
        $response = Http::get($this->baseUrl . '/api/properties', [
            'api_key' => config('services.api.key'),
            'page' => ['number' => $page, 'size' => 100],

        ]);

        return $response->json();
    }

}
