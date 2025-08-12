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
use KiloSierraCharlie\VATSIM\EventsApi;
use KiloSierraCharlie\VATSIM\Enums\EventType;
use PHPUnit\Framework\TestCase;

final class EventsApiTest extends TestCase
{
    private const TEST_DATA = '{"data":[{"id":12000,"type":"Event","name":"TEST_EVENT","link":"TEST_LINK","organisers":[{"region":"TEST_REGION","division":"TEST_DIVISION","subdivision":null,"organised_by_vatsim":false}],"airports":[{"icao":"EGLL"},{"icao":"EGKK"}],"routes":[{"departure":"EGLL","arrival":"EGKK","route":"TEST_ROUTE"}],"start_time":"2025-08-12T16:00:00.000000Z","end_time":"2025-08-12T19:00:00.000000Z","short_description":"TEST_SHORT_DESC","description":"TEST_DESC","banner":"TEST_BANNER"},{"id":99111,"type":"Event","name":"TEST_EVENT","link":"TEST_LINK","organisers":[],"airports":[],"routes":[],"start_time":"2025-08-12T16:00:00.000000Z","end_time":"2025-08-12T19:00:00.000000Z","short_description":"TEST_SHORT_DESC","description":"TEST_DESC","banner":"TEST_BANNER"}]}';

    private function makeApi(Client $client): EventsApi
    {
        $api = new EventsApi();

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
            'base_uri' => 'https://my.vatsim.net',
            'http_errors' => true,
            'timeout' => 5,
        ]);
    }

    public function testAllEventData(): void
    {
        $history = [];
        $client = $this->makeClient([new Response(200, [], self::TEST_DATA)], $history);
        $api = $this->makeApi($client);

        $results = $api->getScheduled();

        // Validate 1 request only.
        $this->assertCount(1, $history);

        // Validate URL is correct.
        $req = $history[0]['request'];
        $this->assertSame('https://my.vatsim.net/api/v2/events/latest', (string) $req->getUri());

        // Validate 3 results returned and parsed into collection.
        $this->assertCount(2, $results->all());

        // Validate result.
        $this->assertSame(12000, $results->all()[0]->id);
        $this->assertSame(EventType::EVENT, $results->all()[0]->type);
        $this->assertSame('TEST_EVENT', $results->all()[0]->name);
        $this->assertEquals(new \DateTimeImmutable('2025-08-12 16:00:00'), $results->all()[0]->start_time);
        $this->assertEquals(new \DateTimeImmutable('2025-08-12 19:00:00'), $results->all()[0]->end_time);

        // Test Organiser
        $this->assertCount(1, $results->all()[0]->organisers->all());

        $this->assertSame('TEST_REGION', $results->all()[0]->organisers->all()[0]->region);
        $this->assertSame('TEST_DIVISION', $results->all()[0]->organisers->all()[0]->division);
        $this->assertSame(null, $results->all()[0]->organisers->all()[0]->subdivision);
        $this->assertSame(false, $results->all()[0]->organisers->all()[0]->organised_by_vatsim);

        // Test Airport
        $this->assertCount(2, $results->all()[0]->airports->all());

        $this->assertSame('EGLL', $results->all()[0]->airports->all()[0]->icao);

        // Test Route
        $this->assertCount(1, $results->all()[0]->routes->all());

        $this->assertSame('TEST_ROUTE', $results->all()[0]->routes->all()[0]->route);
    }
}
