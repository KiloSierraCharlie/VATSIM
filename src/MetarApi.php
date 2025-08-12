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
use KiloSierraCharlie\VATSIM\Models\MetarCollection;

final class MetarApi extends APIHandler
{
    protected string $baseURL = 'https://metar.vatsim.net';

    public function getMetar(string $icao): MetarCollection
    {
        try {
            $response = $this->client->get(
                '/'.$icao
            );
            $mets = preg_split("/\R+/", $response->getBody()->getContents(), -1, PREG_SPLIT_NO_EMPTY);

            return Hydrator::hydrate(MetarCollection::class, $mets);
        } catch (ClientException $e) {
            $code = $e->getCode();

            if (401 === $code || 403 === $code) {
                throw new AccessDeniedException(null, $code);
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
