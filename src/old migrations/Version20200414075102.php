<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414075102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE date_create date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE employee CHANGE date_create date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_uptdate date_uptdate DATETIME DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE repair CHANGE date_create date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE repstatus CHANGE date_create date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE date_create date_create DATE NOT NULL, CHANGE date_update date_update DATE DEFAULT NULL, CHANGE date_delete date_delete DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE employee CHANGE date_create date_create VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_uptdate date_uptdate DATE DEFAULT NULL, CHANGE date_delete date_delete DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE repair CHANGE date_create date_create DATE NOT NULL, CHANGE date_update date_update DATE DEFAULT NULL, CHANGE date_delete date_delete DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE repstatus CHANGE date_create date_create DATE NOT NULL, CHANGE date_update date_update DATE DEFAULT NULL, CHANGE date_delete date_delete DATE DEFAULT NULL');
    }
}
