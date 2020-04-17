<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200416110204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date_create DATE NOT NULL, date_update DATE NOT NULL, date_delete DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repair ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE434216BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_8EE434216BF700BD ON repair (status_id)');
        $this->addSql('ALTER TABLE repstatus ADD status_id INT DEFAULT NULL, DROP status');
        $this->addSql('ALTER TABLE repstatus ADD CONSTRAINT FK_86FD45B66BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_86FD45B66BF700BD ON repstatus (status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE434216BF700BD');
        $this->addSql('ALTER TABLE repstatus DROP FOREIGN KEY FK_86FD45B66BF700BD');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP INDEX IDX_8EE434216BF700BD ON repair');
        $this->addSql('ALTER TABLE repair DROP status_id');
        $this->addSql('DROP INDEX IDX_86FD45B66BF700BD ON repstatus');
        $this->addSql('ALTER TABLE repstatus ADD status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP status_id');
    }
}
