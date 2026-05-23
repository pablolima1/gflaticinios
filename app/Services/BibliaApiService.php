<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class BibliaApiService
{
    protected string $baseUrl;
    protected string $token;
    protected string $defaultVersion;

    public function __construct()
    {
        $this->baseUrl = config('biblia.base_url');
        $this->token = config('biblia.token');
        $this->defaultVersion = config('biblia.default_version');

        if (empty($this->token)) {
            throw new RuntimeException('BIBLIA_API_TOKEN não está definido no .env');
        }
    }

    public function versiculoDoDia(): array
    {
        $cacheKey = 'biblia.versiculo-do-dia.' . now()->format('Y-m-d');

        return Cache::remember($cacheKey, now()->endOfDay(), function () {
            return $this->fetchVersiculoRandom();
        });
    }

    protected function fetchVersiculoRandom(): array
    {
        $endpoint = sprintf('%s/versions/%s/random',
            rtrim($this->baseUrl, '/'),
            $this->defaultVersion
        );

        $response = Http::withToken($this->token)
            ->acceptJson()
            ->get($endpoint);

        if (! $response->successful()) {
            Log::warning('Erro ao consultar versículo aleatório da Bíblia', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'texto' => 'Não foi possível carregar o versículo do dia.',
                'referencia' => 'BibliaAPI',
                'endpoint' => $endpoint,
            ];
        }

        $data = $response->json()['data'] ?? [];

        return [
            'texto' => $data['text'] ?? $data['texto'] ?? 'Versículo não disponível.',
            'referencia' => $data['reference'] ?? $data['referencia'] ?? 'BibliaAPI',
            'endpoint' => $endpoint,
        ];
    }
}
