<?php

namespace App\Tests\Integration;

use App\Entity\GuestList;
use App\Entity\Tables;
use App\Tests\DatabaseTestCase;

class FixturesLoadTest extends DatabaseTestCase
{
    public function testFixturesLoaded(): void
    {
        $tables = $this->em->getRepository(Tables::class)->findAll();
        $guests = $this->em->getRepository(GuestList::class)->findAll();

        $this->assertCount(10, $tables);
        $this->assertCount(50, $guests);
    }
}
