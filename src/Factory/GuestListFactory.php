<?php

namespace App\Factory;

use App\Entity\GuestList;
use App\Entity\Tables;
use Faker\Factory;

class GuestListFactory
{
    public static function createGuestList(Tables $table = null): GuestList
    {
        $faker = Factory::create();

        $guest = new GuestList();
        $guest->setName($faker->name());
        $guest->setIsPresent($faker->boolean());

        if ($table) {
            $guest->setTables($table);
        }

        return $guest;
    }

    public static function createManyGuestLists(int $count, Tables $table = null): array
    {
        $guests = [];
        for ($i = 0; $i < $count; $i++) {
            $guests[] = self::createGuestList($table);
        }
        return $guests;
    }
}
