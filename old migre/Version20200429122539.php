<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429122539 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE provider_device (id INT AUTO_INCREMENT NOT NULL, device_id INT DEFAULT NULL, service_provider_id INT DEFAULT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATE DEFAULT NULL, date_send DATE DEFAULT NULL, UNIQUE INDEX UNIQ_5E1E551E94A4C7D4 (device_id), INDEX IDX_5E1E551EC6C98E06 (service_provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE provider_device ADD CONSTRAINT FK_5E1E551E94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE provider_device ADD CONSTRAINT FK_5E1E551EC6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id)');
        $this->addSql('DROP TABLE repair_device');
        $this->addSql('ALTER TABLE repair CHANGE device_id device_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE repair_device (id INT AUTO_INCREMENT NOT NULL, device_id INT DEFAULT NULL, service_provider_id INT DEFAULT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATE DEFAULT NULL, date_send DATE DEFAULT NULL, UNIQUE INDEX UNIQ_D6EF868994A4C7D4 (device_id), INDEX IDX_D6EF8689C6C98E06 (service_provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE repair_device ADD CONSTRAINT FK_D6EF868994A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE repair_device ADD CONSTRAINT FK_D6EF8689C6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id)');
        $this->addSql('DROP TABLE provider_device');
        $this->addSql('ALTER TABLE repair CHANGE device_id device_id INT DEFAULT NULL');
    }
}
