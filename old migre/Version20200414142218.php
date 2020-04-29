<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414142218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, phonenumber VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, genre TINYINT(1) NOT NULL, date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, date_update DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, phonenumber VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, date_uptdate DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, role VARCHAR(255) DEFAULT \'ROLE_USER\' NOT NULL, genre TINYINT(1) NOT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, emp_id INT NOT NULL, date_supported DATE NOT NULL, date_end DATE DEFAULT NULL, duration INT NOT NULL, image VARCHAR(255) NOT NULL, date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, date_update DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, description VARCHAR(1000) NOT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_8EE4342119EB6921 (client_id), INDEX IDX_8EE434217A663008 (emp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repstatus (id INT AUTO_INCREMENT NOT NULL, rep_id INT NOT NULL, status VARCHAR(255) NOT NULL, comment VARCHAR(1000) DEFAULT NULL, date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, date_update DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_86FD45B654C549EA (rep_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE4342119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE434217A663008 FOREIGN KEY (emp_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE repstatus ADD CONSTRAINT FK_86FD45B654C549EA FOREIGN KEY (rep_id) REFERENCES repair (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE4342119EB6921');
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE434217A663008');
        $this->addSql('ALTER TABLE repstatus DROP FOREIGN KEY FK_86FD45B654C549EA');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE repair');
        $this->addSql('DROP TABLE repstatus');
    }
}
