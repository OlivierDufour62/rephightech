<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504072325 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, phonenumber VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, genre TINYINT(1) DEFAULT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX UNIQ_C7440455EFF286D2 (phonenumber), UNIQUE INDEX UNIQ_C7440455E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, ref_device VARCHAR(255) NOT NULL, mark VARCHAR(255) DEFAULT NULL, guarantee TINYINT(1) NOT NULL, be_same TINYINT(1) NOT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, users_id INT DEFAULT NULL, device_id INT NOT NULL, status_id INT NOT NULL, date_supported DATE NOT NULL, date_end DATE DEFAULT NULL, duration INT NOT NULL, image VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, description VARCHAR(1000) NOT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, reference VARCHAR(150) NOT NULL, INDEX IDX_8EE4342119EB6921 (client_id), INDEX IDX_8EE4342167B3B43D (users_id), INDEX IDX_8EE4342194A4C7D4 (device_id), INDEX IDX_8EE434216BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repstatus (id INT AUTO_INCREMENT NOT NULL, rep_id INT NOT NULL, status_id INT NOT NULL, comment VARCHAR(1000) DEFAULT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_86FD45B654C549EA (rep_id), INDEX IDX_86FD45B66BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_provider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATE DEFAULT NULL, api_token VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_6BB228A17BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT \'En attente\' NOT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, phonenumber VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, role VARCHAR(255) DEFAULT \'ROLE_USER\' NOT NULL, genre TINYINT(1) NOT NULL, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9EFF286D2 (phonenumber), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE4342119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE4342167B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE4342194A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE434216BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE repstatus ADD CONSTRAINT FK_86FD45B654C549EA FOREIGN KEY (rep_id) REFERENCES repair (id)');
        $this->addSql('ALTER TABLE repstatus ADD CONSTRAINT FK_86FD45B66BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE provider_device DROP INDEX UNIQ_5E1E551E94A4C7D4, ADD INDEX IDX_5E1E551E94A4C7D4 (device_id)');
        $this->addSql('ALTER TABLE provider_device CHANGE device_id device_id INT NOT NULL, CHANGE service_provider_id service_provider_id INT NOT NULL');
        $this->addSql('ALTER TABLE provider_device ADD CONSTRAINT FK_5E1E551EC6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id)');
        $this->addSql('ALTER TABLE provider_device ADD CONSTRAINT FK_5E1E551E94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE4342119EB6921');
        $this->addSql('ALTER TABLE provider_device DROP FOREIGN KEY FK_5E1E551E94A4C7D4');
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE4342194A4C7D4');
        $this->addSql('ALTER TABLE repstatus DROP FOREIGN KEY FK_86FD45B654C549EA');
        $this->addSql('ALTER TABLE provider_device DROP FOREIGN KEY FK_5E1E551EC6C98E06');
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE434216BF700BD');
        $this->addSql('ALTER TABLE repstatus DROP FOREIGN KEY FK_86FD45B66BF700BD');
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE4342167B3B43D');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE repair');
        $this->addSql('DROP TABLE repstatus');
        $this->addSql('DROP TABLE service_provider');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE provider_device DROP INDEX IDX_5E1E551E94A4C7D4, ADD UNIQUE INDEX UNIQ_5E1E551E94A4C7D4 (device_id)');
        $this->addSql('ALTER TABLE provider_device CHANGE service_provider_id service_provider_id INT DEFAULT NULL, CHANGE device_id device_id INT DEFAULT NULL');
    }
}
