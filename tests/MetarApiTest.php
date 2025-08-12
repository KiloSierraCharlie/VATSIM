<?php

/*
 *
 * (c) Kieran Cross
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KiloSierraCharlie\VATSIM\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use KiloSierraCharlie\VATSIM\MetarApi;
use PHPUnit\Framework\TestCase;

final class MetarApiTest extends TestCase
{
    private const TEST_DATA = <<<METAR
        EGLC 121250Z AUTO 22008KT 9999 BKN020 21/13 Q1016
        EGLF 121250Z 23012KT 9999 FEW025 22/12 Q1016
        EGLK 042120Z 24010KT 9999 SCT030 23/13 Q1016
    METAR;

    private function makeApi(Client $client): MetarApi
    {
        $api = new MetarApi();

        $ref = new \ReflectionClass($api);
        $prop = $ref->getProperty('client');
        $prop->setAccessible(true);
        $prop->setValue($api, $client);

        return $api;
    }

    private function makeClient(array $queue, array &$history): Client
    {
        $mock = new MockHandler($queue);
        $stack = HandlerStack::create($mock);
        $history = [];
        $stack->push(Middleware::history($history));

        return new Client([
            'handler' => $stack,
            'base_uri' => 'https://metar.vatsim.net',
            'http_errors' => true,
            'timeout' => 5,
        ]);
    }

    public function testApiCallAndData(): void
    {
        $history = [];
        $client = $this->makeClient([new Response(200, [], self::TEST_DATA)], $history);
        $api = $this->makeApi($client);

        $results = $api->getMetar('EGL');

        // Validate 1 request only.
        $this->assertCount(1, $history);

        // Validate URL is correct.
        $req = $history[0]['request'];
        $this->assertSame('https://metar.vatsim.net/EGL', (string) $req->getUri());

        // Validate 3 results returned and parsed into collection.
        $this->assertCount(3, $results->all());

        // Validate first result.
        $this->assertSame('EGLC', $results->all()[0]->icao);
        $this->assertEquals(new \DateTimeImmutable('1970-01-12 12:50:00'), $results->all()[0]->observationTime);
        $this->assertSame('AUTO 22008KT 9999 BKN020 21/13 Q1016', $results->all()[0]->data);

        // Validate last result.
        $this->assertSame('EGLK', $results->all()[2]->icao);
        $this->assertEquals(new \DateTimeImmutable('1970-01-04 21:20:00'), $results->all()[2]->observationTime);
        $this->assertSame('24010KT 9999 SCT030 23/13 Q1016', $results->all()[2]->data);
    }
}
