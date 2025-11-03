<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251103172823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guest_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tables_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, is_present BOOLEAN DEFAULT NULL, CONSTRAINT FK_6072A54585405FD2 FOREIGN KEY (tables_id) REFERENCES tables (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6072A54585405FD2 ON guest_list (tables_id)');
        $this->addSql('CREATE TABLE tables (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, num INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, max_guests INTEGER DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE guest_list');
        $this->addSql('DROP TABLE tables');
    }
}
