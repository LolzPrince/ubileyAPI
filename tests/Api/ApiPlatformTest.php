<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\GuestList;
use App\Entity\Tables;

class ApiPlatformTest extends ApiTestCase
{
    protected static ?bool $alwaysBootKernel = true;

    public function testGetGuestLists(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/guest_lists');

        $this->assertResponseIsSuccessful();

        $data = $response->toArray()['member'];
        $this->assertIsArray($data);

        if (!empty($data)) {
            $guest = $data[0];
            $this->assertArrayHasKey('id', $guest);
            $this->assertArrayHasKey('name', $guest);
            $this->assertArrayHasKey('isPresent', $guest);
            $this->assertArrayHasKey('tables', $guest);

            if ($guest['tables'] !== null) {
                $this->assertArrayHasKey('id', $guest['tables']);
                $this->assertArrayHasKey('num', $guest['tables']);
            }
        }
    }

    public function testGetGuestListById(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/guest_lists/1');

        $this->assertResponseIsSuccessful();

        $guest = $response->toArray();
        $this->assertArrayHasKey('id', $guest);
        $this->assertArrayHasKey('name', $guest);
        $this->assertArrayHasKey('isPresent', $guest);
        $this->assertArrayHasKey('tables', $guest);
    }

    public function testGetTables(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/tables');

        $this->assertResponseIsSuccessful();

        $tables = $response->toArray()['member'];
        $this->assertIsArray($tables);

        if (!empty($tables)) {
            $table = $tables[0];
            $this->assertArrayHasKey('id', $table);
            $this->assertArrayHasKey('num', $table);
            $this->assertArrayHasKey('description', $table);
            $this->assertArrayHasKey('maxGuests', $table);
            $this->assertArrayHasKey('guests', $table);
        }
    }

    public function testGetTableById(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/tables/1');

        $this->assertResponseIsSuccessful();

        $table = $response->toArray();
        $this->assertArrayHasKey('id', $table);
        $this->assertArrayHasKey('num', $table);
        $this->assertArrayHasKey('description', $table);
        $this->assertArrayHasKey('maxGuests', $table);
        $this->assertArrayHasKey('guests', $table);
    }

    public function testGetTableGuests(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/tables/1/guests');

        $this->assertResponseIsSuccessful();

        $guests = $response->toArray()['member'];
        $this->assertIsArray($guests);

        if (!empty($guests)) {
            $guest = $guests[0];
            $this->assertArrayHasKey('id', $guest);
            $this->assertArrayHasKey('name', $guest);
            $this->assertArrayHasKey('isPresent', $guest);
        }
    }

    public function testGetTablesStats(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/tables_stats');

        $this->assertResponseIsSuccessful();

        $stats = $response->toArray()['member'];
        $this->assertIsArray($stats);

        if (!empty($stats)) {
            $stat = $stats[0];
            $this->assertArrayHasKey('id', $stat);
            $this->assertArrayHasKey('num', $stat);
            $this->assertArrayHasKey('maxGuests', $stat);
            $this->assertArrayHasKey('booking', $stat);
            $this->assertArrayHasKey('guestIsPresent', $stat);
        }
    }

    public function testPatchGuestList(): void
    {
        $client = static::createClient();
        $response = $client->request('PATCH', '/api/guest_lists/1', [
            'json' => ['isPresent' => true]
        ]);

        $this->assertResponseIsSuccessful();

        $guest = $response->toArray();
        $this->assertTrue($guest['isPresent']);
    }

    public function testPatchTable(): void
    {
        $client = static::createClient();
        $response = $client->request('PATCH', '/api/tables/1', [
            'json' => ['description' => 'Updated table description']
        ]);

        $this->assertResponseIsSuccessful();

        $table = $response->toArray();
        $this->assertEquals('Updated table description', $table['description']);
    }
}
