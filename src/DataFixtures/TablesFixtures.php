<?php

namespace App\DataFixtures;

use App\Entity\Tables;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TablesFixtures extends Fixture
{
    public const TABLE_1 = 'table_1';
    public const TABLE_2 = 'table_2';
    public const TABLE_3 = 'table_3';
    public const TABLE_4 = 'table_4';
    public const TABLE_5 = 'table_5';
    public const TABLE_6 = 'table_6';

    public function load(ObjectManager $manager): void
    {
        $tables = [
            ['num' => 1, 'description' => 'У окна', 'maxGuests' => 4, 'ref' => self::TABLE_1],
            ['num' => 2, 'description' => 'В центре зала', 'maxGuests' => 6, 'ref' => self::TABLE_2],
            ['num' => 3, 'description' => 'В углу', 'maxGuests' => 2, 'ref' => self::TABLE_3],
            ['num' => 4, 'description' => 'VIP зона', 'maxGuests' => 8, 'ref' => self::TABLE_4],
            ['num' => 5, 'description' => 'На террасе', 'maxGuests' => 4, 'ref' => self::TABLE_5],
            ['num' => 6, 'description' => 'У бара', 'maxGuests' => 2, 'ref' => self::TABLE_6],
        ];

        foreach ($tables as $tableData) {
            $table = new Tables();
            $table->setNum($tableData['num']);
            $table->setDescription($tableData['description']);
            $table->setMaxGuests($tableData['maxGuests']);

            $manager->persist($table);
            $this->addReference($tableData['ref'], $table);
        }

        $manager->flush();
    }
}
