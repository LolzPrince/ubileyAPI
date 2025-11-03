<?php

namespace App\Factory;

use App\Entity\Tables;
use Faker\Factory;

class TablesFactory
{
    private static $usedNumbers = [];

    public static function createTable(array $attributes = []): Tables
    {
        $faker = Factory::create();

        $table = new Tables();

        // Генерируем уникальный номер стола
        $num = $attributes['num'] ?? self::generateUniqueNumber();
        $table->setNum($num);

        $table->setDescription($attributes['description'] ?? $faker->optional(0.7)->text(200));
        $table->setMaxGuests($attributes['maxGuests'] ?? $faker->numberBetween(2, 20));

        return $table;
    }

    public static function createManyTables(int $count): array
    {
        $tables = [];
        for ($i = 0; $i < $count; $i++) {
            $tables[] = self::createTable();
        }
        return $tables;
    }

    private static function generateUniqueNumber(): int
    {
        $faker = Factory::create();
        $num = $faker->numberBetween(1, 100);

        // Проверяем уникальность номера
        while (in_array($num, self::$usedNumbers)) {
            $num = $faker->numberBetween(1, 100);
        }

        self::$usedNumbers[] = $num;
        return $num;
    }
}
