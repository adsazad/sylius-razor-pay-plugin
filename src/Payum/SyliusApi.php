<?php

declare(strict_types=1);

namespace Srkits\SyliusRazorPayPlugin\Payum;

final class SyliusApi
{
    /** @var string */
    private $apiKey;
    private $apiSecret;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;

    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
    public function getApiSecret(): string
    {
        return $this->apiSecret;
    }
}