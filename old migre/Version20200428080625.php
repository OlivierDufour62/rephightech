<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200428080625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repair_device ADD service_provider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repair_device ADD CONSTRAINT FK_D6EF8689C6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id)');
        $this->addSql('CREATE INDEX IDX_D6EF8689C6C98E06 ON repair_device (service_provider_id)');
        $this->addSql('ALTER TABLE service_provider DROP FOREIGN KEY FK_6BB228A194A4C7D4');
        $this->addSql('ALTER TABLE service_provider DROP FOREIGN KEY FK_6BB228A1D5C925CD');
        $this->addSql('DROP INDEX IDX_6BB228A1D5C925CD ON service_provider');
        $this->addSql('DROP INDEX IDX_6BB228A194A4C7D4 ON service_provider');
        $this->addSql('ALTER TABLE service_provider DROP device_id, DROP repair_device_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repair_device DROP FOREIGN KEY FK_D6EF8689C6C98E06');
        $this->addSql('DROP INDEX IDX_D6EF8689C6C98E06 ON repair_device');
        $this->addSql('ALTER TABLE repair_device DROP service_provider_id');
        $this->addSql('ALTER TABLE service_provider ADD device_id INT NOT NULL, ADD repair_device_id INT NOT NULL');
        $this->addSql('ALTER TABLE service_provider ADD CONSTRAINT FK_6BB228A194A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE service_provider ADD CONSTRAINT FK_6BB228A1D5C925CD FOREIGN KEY (repair_device_id) REFERENCES repair_device (id)');
        $this->addSql('CREATE INDEX IDX_6BB228A1D5C925CD ON service_provider (repair_device_id)');
        $this->addSql('CREATE INDEX IDX_6BB228A194A4C7D4 ON service_provider (device_id)');
    }
}
