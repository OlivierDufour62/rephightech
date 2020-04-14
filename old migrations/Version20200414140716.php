<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414140716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client ADD is_active TINYINT(1) DEFAULT \'true\' NOT NULL');
        $this->addSql('ALTER TABLE employee ADD is_active TINYINT(1) DEFAULT \'true\' NOT NULL');
        $this->addSql('ALTER TABLE repair ADD is_active TINYINT(1) DEFAULT \'true\' NOT NULL');
        $this->addSql('ALTER TABLE repstatus ADD is_active TINYINT(1) DEFAULT \'TRUE\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP is_active');
        $this->addSql('ALTER TABLE employee DROP is_active');
        $this->addSql('ALTER TABLE repair DROP is_active');
        $this->addSql('ALTER TABLE repstatus DROP is_active');
    }
}
