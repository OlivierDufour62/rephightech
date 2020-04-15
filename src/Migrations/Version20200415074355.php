<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200415074355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE date_create date_create DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE employee ADD date_update DATETIME NOT NULL, DROP date_uptdate, CHANGE date_create date_create DATETIME NOT NULL');
        $this->addSql('ALTER TABLE repair CHANGE date_create date_create DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE repstatus CHANGE date_create date_create DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE date_create date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD date_uptdate DATETIME DEFAULT NULL, DROP date_update, CHANGE date_create date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE repair CHANGE date_create date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE repstatus CHANGE date_create date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_update date_update DATETIME DEFAULT NULL');
    }
}
