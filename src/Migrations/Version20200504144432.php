<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504144432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE provider_device DROP FOREIGN KEY FK_5E1E551EC6C98E06');
        $this->addSql('DROP INDEX IDX_5E1E551EC6C98E06 ON provider_device');
        $this->addSql('ALTER TABLE provider_device ADD users_id INT DEFAULT NULL, DROP service_provider_id');
        $this->addSql('ALTER TABLE provider_device ADD CONSTRAINT FK_5E1E551E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5E1E551E67B3B43D ON provider_device (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE provider_device DROP FOREIGN KEY FK_5E1E551E67B3B43D');
        $this->addSql('DROP INDEX IDX_5E1E551E67B3B43D ON provider_device');
        $this->addSql('ALTER TABLE provider_device ADD service_provider_id INT NOT NULL, DROP users_id');
        $this->addSql('ALTER TABLE provider_device ADD CONSTRAINT FK_5E1E551EC6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id)');
        $this->addSql('CREATE INDEX IDX_5E1E551EC6C98E06 ON provider_device (service_provider_id)');
    }
}
