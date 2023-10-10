<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010122638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, country VARCHAR(255) DEFAULT NULL, siren_siret VARCHAR(255) NOT NULL, legal_form VARCHAR(255) DEFAULT NULL, share_capital VARCHAR(255) DEFAULT NULL, city_registration VARCHAR(255) DEFAULT NULL, vat_id VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, description_work LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_4FBF094FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, customer_id INT NOT NULL, invoice_id INT NOT NULL, title VARCHAR(255) NOT NULL, credit_number VARCHAR(255) NOT NULL, refund_reason LONGTEXT NOT NULL, refunded_price DOUBLE PRECISION NOT NULL, credit_validity_duration DATE NOT NULL, status VARCHAR(255) NOT NULL, refund_method VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1CC16EFE979B1AD6 (company_id), INDEX IDX_1CC16EFE9395C3F3 (customer_id), UNIQUE INDEX UNIQ_1CC16EFE2989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, company_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, activity VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, vat_id VARCHAR(255) DEFAULT NULL, siren_siret VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_81398E09979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, customer_id INT NOT NULL, quotation_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, bill_number VARCHAR(255) NOT NULL, from_date VARCHAR(255) DEFAULT NULL, delivery_date VARCHAR(255) NOT NULL, total_price DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, payment_method VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, bill_validity_duration VARCHAR(255) NOT NULL, INDEX IDX_90651744979B1AD6 (company_id), INDEX IDX_906517449395C3F3 (customer_id), UNIQUE INDEX UNIQ_90651744B4EA4E60 (quotation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, customer_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, quote_number VARCHAR(255) NOT NULL, from_date DATE DEFAULT NULL, delivery_date DATE NOT NULL, total_price DOUBLE PRECISION NOT NULL, vat DOUBLE PRECISION NOT NULL, quote_validity_duration DATE NOT NULL, deposit DOUBLE PRECISION DEFAULT NULL, deposit_date DATE DEFAULT NULL, payment_method VARCHAR(255) NOT NULL, payment_days VARCHAR(255) NOT NULL, payment_date_limit DATE NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_474A8DB9979B1AD6 (company_id), INDEX IDX_474A8DB99395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, invoice_id INT NOT NULL, quotation_id INT DEFAULT NULL, credit_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, quantity INT NOT NULL, unit_cost DOUBLE PRECISION NOT NULL, total_price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, vat DOUBLE PRECISION DEFAULT NULL, INDEX IDX_7332E1692989F1FD (invoice_id), INDEX IDX_7332E169B4EA4E60 (quotation_id), INDEX IDX_7332E169CE062FF9 (credit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB9979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB99395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E1692989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169CE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE979B1AD6');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE9395C3F3');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE2989F1FD');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09979B1AD6');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744979B1AD6');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517449395C3F3');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744B4EA4E60');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB9979B1AD6');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB99395C3F3');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1692989F1FD');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169B4EA4E60');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169CE062FF9');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
