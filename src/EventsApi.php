<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\TransferException;
use KiloSierraCharlie\VATSIM\Exceptions\AccessDeniedException;
use KiloSierraCharlie\VATSIM\Exceptions\ConnectionFailureException;
use KiloSierraCharlie\VATSIM\Exceptions\NotFoundException;
use KiloSierraCharlie\VATSIM\Exceptions\ServerException;
use KiloSierraCharlie\VATSIM\Hydration\Hydrator;
use KiloSierraCharlie\VATSIM\Models\EventCollection;
use KiloSierraCharlie\VATSIM\Models\Event;

enum EventFilterLocation: string
{
    case DIVISION = "division";
    case REGION = "region";
}

final class EventsApi extends APIHandler
{
    protected string $baseURL = 'https://my.vatsim.net/';

    public function getScheduled( ?int $limit = null ): EventCollection
    {
        try {
            $response = $this->client->get(
                '/api/v2/events/latest'.($limit ? '/'.$limit : '')
            );
            return Hydrator::fromResponse(EventCollection::class, $response, "data");
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
    
    public function getScheduledInArea( EventFilterLocation $location, string $locationId ): EventCollection
    {
        try {
            $response = $this->client->get(
                '/api/v2/events/view/'.$location->value.'/'.$locationId
            );
            return Hydrator::fromResponse(EventCollection::class, $response, "data");
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

    public function getEvent( int $eventId = null ): Event
    {
        try {
            $response = $this->client->get(
                '/api/v2/events/view/'.$eventId
            );
            return Hydrator::fromResponse(Event::class, $response, "data");
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
