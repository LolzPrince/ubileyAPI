<?php

namespace App\DataFixtures;

use App\Entity\GuestList;
use App\Entity\Tables;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GuestListFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $guests = [
            ['name' => 'Иван Иванов', 'table' => TablesFixtures::TABLE_1, 'isPresent' => true],
            ['name' => 'Мария Петрова', 'table' => TablesFixtures::TABLE_1, 'isPresent' => true],
            ['name' => 'Алексей Сидоров', 'table' => TablesFixtures::TABLE_2, 'isPresent' => true],
            ['name' => 'Елена Козлова', 'table' => TablesFixtures::TABLE_2, 'isPresent' => false],
            ['name' => 'Дмитрий Волков', 'table' => TablesFixtures::TABLE_3, 'isPresent' => true],
            ['name' => 'Ольга Белова', 'table' => TablesFixtures::TABLE_4, 'isPresent' => true],
            ['name' => 'Сергей Новиков', 'table' => TablesFixtures::TABLE_4, 'isPresent' => true],
            ['name' => 'Анна Морозова', 'table' => TablesFixtures::TABLE_4, 'isPresent' => false],
            ['name' => 'Павел Лебедев', 'table' => TablesFixtures::TABLE_5, 'isPresent' => true],
            ['name' => 'Наталья Соколова', 'table' => TablesFixtures::TABLE_6, 'isPresent' => true],
        ];

        foreach ($guests as $guestData) {
            $guest = new GuestList();
            $guest->setName($guestData['name']);
            $guest->setIsPresent($guestData['isPresent']);
            $guest->setTables($this->getReference($guestData['table'], Tables::class));

            $manager->persist($guest);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TablesFixtures::class,
        ];
    }
}
