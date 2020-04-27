<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200424094641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE device CHANGE mark mark VARCHAR(255) DEFAULT NULL, CHANGE date_create date_create DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE employee ADD api_token VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A17BA2F5EB ON employee (api_token)');
        $this->addSql('ALTER TABLE repair_device CHANGE date_create date_create DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE service_provider CHANGE date_create date_create DATETIME NOT NULL, CHANGE date_update date_update DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE device CHANGE mark mark VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_create date_create DATE NOT NULL, CHANGE date_update date_update DATE DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_5D9F75A17BA2F5EB ON employee');
        $this->addSql('ALTER TABLE employee DROP api_token');
        $this->addSql('ALTER TABLE repair_device CHANGE date_create date_create DATE NOT NULL, CHANGE date_update date_update DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE service_provider CHANGE date_create date_create DATE NOT NULL, CHANGE date_update date_update DATE DEFAULT NULL');
    }
}
