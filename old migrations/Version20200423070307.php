<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200423070307 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE4342194A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('CREATE INDEX IDX_8EE4342194A4C7D4 ON repair (device_id)');
        $this->addSql('DROP INDEX IDX_6BB228A1DF57C38B ON service_provider');
        $this->addSql('ALTER TABLE service_provider CHANGE repair_provider_id repair_device_id INT NOT NULL');
        $this->addSql('ALTER TABLE service_provider ADD CONSTRAINT FK_6BB228A1D5C925CD FOREIGN KEY (repair_device_id) REFERENCES repair_device (id)');
        $this->addSql('CREATE INDEX IDX_6BB228A1D5C925CD ON service_provider (repair_device_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE4342194A4C7D4');
        $this->addSql('DROP INDEX IDX_8EE4342194A4C7D4 ON repair');
        $this->addSql('ALTER TABLE service_provider DROP FOREIGN KEY FK_6BB228A1D5C925CD');
        $this->addSql('DROP INDEX IDX_6BB228A1D5C925CD ON service_provider');
        $this->addSql('ALTER TABLE service_provider CHANGE repair_device_id repair_provider_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_6BB228A1DF57C38B ON service_provider (repair_provider_id)');
    }
}
