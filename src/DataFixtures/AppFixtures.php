<?php

namespace App\DataFixtures;

use App\Entity\GuestList;
use App\Entity\Tables;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Создаем столы
        $tables = [];
        for ($i = 1; $i <= 10; $i++) {
            $table = new Tables();
            $table->setNum($i);
            $table->setDescription($faker->optional(0.7)->text(200));
            $table->setMaxGuests($faker->numberBetween(2, 20));

            $manager->persist($table);
            $tables[] = $table;
        }

        // Создаем гостей
        for ($i = 0; $i < 50; $i++) {
            $guest = new GuestList();
            $guest->setName($faker->name());
            $guest->setIsPresent($faker->boolean());
            $guest->setTables($faker->randomElement($tables));

            $manager->persist($guest);
        }

        $manager->flush();
    }
}
