<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200423065430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service_provider DROP FOREIGN KEY FK_6BB228A1DF57C38B');
        $this->addSql('CREATE TABLE repair_device (id INT AUTO_INCREMENT NOT NULL, device_id INT DEFAULT NULL, date_create DATE NOT NULL, date_update DATE DEFAULT NULL, date_delete DATE DEFAULT NULL, date_send DATE DEFAULT NULL, UNIQUE INDEX UNIQ_D6EF868994A4C7D4 (device_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repair_device ADD CONSTRAINT FK_D6EF868994A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('DROP TABLE repair_provider');
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

        $this->addSql('ALTER TABLE service_provider DROP FOREIGN KEY FK_6BB228A1D5C925CD');
        $this->addSql('CREATE TABLE repair_provider (id INT AUTO_INCREMENT NOT NULL, device_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_FB5C0A3794A4C7D4 (device_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE repair_provider ADD CONSTRAINT FK_FB5C0A3794A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('DROP TABLE repair_device');
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE4342194A4C7D4');
        $this->addSql('DROP INDEX IDX_8EE4342194A4C7D4 ON repair');
        $this->addSql('DROP INDEX IDX_6BB228A1D5C925CD ON service_provider');
        $this->addSql('ALTER TABLE service_provider CHANGE repair_device_id repair_provider_id INT NOT NULL');
        $this->addSql('ALTER TABLE service_provider ADD CONSTRAINT FK_6BB228A1DF57C38B FOREIGN KEY (repair_provider_id) REFERENCES repair_provider (id)');
        $this->addSql('CREATE INDEX IDX_6BB228A1DF57C38B ON service_provider (repair_provider_id)');
    }
}
