<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Api;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\TransferException;
use KiloSierraCharlie\VATSIM\Enums\ServerType;
use KiloSierraCharlie\VATSIM\Exceptions\AccessDeniedException;
use KiloSierraCharlie\VATSIM\Exceptions\ConnectionFailureException;
use KiloSierraCharlie\VATSIM\Exceptions\NotFoundException;
use KiloSierraCharlie\VATSIM\Exceptions\ServerException;
use KiloSierraCharlie\VATSIM\Hydration\Hydrator;
use KiloSierraCharlie\VATSIM\Models\DataApi\ATISCollection;
use KiloSierraCharlie\VATSIM\Models\DataApi\AudioClientCollection;
use KiloSierraCharlie\VATSIM\Models\DataApi\NetworkData;
use KiloSierraCharlie\VATSIM\Models\DataApi\ServerCollection;
use KiloSierraCharlie\VATSIM\APIHandler;

final class Data extends APIHandler
{
    protected string $baseURL = 'https://data.vatsim.net/';

    public function getServers(ServerType $type = ServerType::ALL): ServerCollection
    {
        try {
            $response = $this->client->get(
                '/v3/'.$type->value
            );

            return Hydrator::fromResponse(ServerCollection::class, $response);
        } catch (ClientException $e) {
            $code = $e->getCode();

            if (401 === $code || 403 === $code) {
                throw new AccessDeniedException($e->getMessage(), $code);
            }
            if (404 === $code) {
                throw new NotFoundException(null, $code);
            }
            if (500 === $code || 503 === $code) {
                throw new ServerException($e->getMessage(), $code);
            }

            throw new ConnectionFailureException($e->getMessage());
        } catch (TransferException $e) {
            throw new ConnectionFailureException($e->getMessage());
        }
    }

    public function getAudioClients(): AudioClientCollection
    {
        try {
            $response = $this->client->get(
                '/v3/transceivers-data.json'
            );

            return Hydrator::fromResponse(AudioClientCollection::class, $response);
        } catch (ClientException $e) {
            $code = $e->getCode();

            if (401 === $code || 403 === $code) {
                throw new AccessDeniedException($e->getMessage(), $code);
            }
            if (404 === $code) {
                throw new NotFoundException(null, $code);
            }
            if (500 === $code || 503 === $code) {
                throw new ServerException($e->getMessage(), $code);
            }

            throw new ConnectionFailureException($e->getMessage());
        } catch (TransferException $e) {
            throw new ConnectionFailureException($e->getMessage());
        }
    }

    public function getATIS(): ATISCollection
    {
        try {
            $response = $this->client->get(
                '/v3/afv-atis-data.json'
            );

            return Hydrator::fromResponse(ATISCollection::class, $response);
        } catch (ClientException $e) {
            $code = $e->getCode();

            if (401 === $code || 403 === $code) {
                throw new AccessDeniedException($e->getMessage(), $code);
            }
            if (404 === $code) {
                throw new NotFoundException(null, $code);
            }
            if (500 === $code || 503 === $code) {
                throw new ServerException($e->getMessage(), $code);
            }

            throw new ConnectionFailureException($e->getMessage());
        } catch (TransferException $e) {
            throw new ConnectionFailureException($e->getMessage());
        }
    }

    public function getNetworkData(): NetworkData
    {
        try {
            $response = $this->client->get(
                '/v3/vatsim-data.json'
            );

            return Hydrator::fromResponse(NetworkData::class, $response);
        } catch (ClientException $e) {
            $code = $e->getCode();

            if (401 === $code || 403 === $code) {
                throw new AccessDeniedException($e->getMessage(), $code);
            }
            if (404 === $code) {
                throw new NotFoundException(null, $code);
            }
            if (500 === $code || 503 === $code) {
                throw new ServerException($e->getMessage(), $code);
            }

            throw new ConnectionFailureException($e->getMessage());
        } catch (TransferException $e) {
            throw new ConnectionFailureException($e->getMessage());
        }
    }
}
