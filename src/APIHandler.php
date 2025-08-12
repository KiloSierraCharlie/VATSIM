<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM;

use GuzzleHttp\Client;
use KiloSierraCharlie\VATSIM\Exceptions\UnconfiguredException;

abstract class APIHandler
{
    protected string $baseURL = '';
    protected Client $client;

    public function __construct(
        private ?string $apiKey = null
    ) {
        $headers = [
            'Accept' => 'application/json',
        ];

        if (null !== $this->apiKey) {
            $headers['X-Api-Key'] = $this->apiKey;
        }

        $this->client = new Client([
            'base_uri' => $this->baseURL,
            'timeout' => 60,
            'headers' => $headers,
        ]);

        if (!$this->validateConfiguration()) {
            throw new UnconfiguredException();
        }
    }

    protected function validateConfiguration(): bool
    {
        return true;
    }
}
