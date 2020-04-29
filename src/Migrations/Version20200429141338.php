<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429141338 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE provider_device DROP INDEX UNIQ_5E1E551E94A4C7D4, ADD INDEX IDX_5E1E551E94A4C7D4 (device_id)');
        $this->addSql('ALTER TABLE provider_device CHANGE device_id device_id INT NOT NULL, CHANGE service_provider_id service_provider_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE provider_device DROP INDEX IDX_5E1E551E94A4C7D4, ADD UNIQUE INDEX UNIQ_5E1E551E94A4C7D4 (device_id)');
        $this->addSql('ALTER TABLE provider_device CHANGE service_provider_id service_provider_id INT DEFAULT NULL, CHANGE device_id device_id INT DEFAULT NULL');
    }
}
