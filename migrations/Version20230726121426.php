<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726121426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE credit (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, customer_id INT NOT NULL, invoice_id INT NOT NULL, title VARCHAR(255) NOT NULL, credit_number VARCHAR(255) NOT NULL, refund_reason LONGTEXT NOT NULL, refunded_price DOUBLE PRECISION NOT NULL, credit_validity_duration DATE NOT NULL, status VARCHAR(255) NOT NULL, refund_method VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1CC16EFE979B1AD6 (company_id), INDEX IDX_1CC16EFE9395C3F3 (customer_id), INDEX IDX_1CC16EFE2989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, customer_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, bill_number VARCHAR(255) NOT NULL, from_date DATE DEFAULT NULL, deelivery_date DATE NOT NULL, total_price DOUBLE PRECISION NOT NULL, vat DOUBLE PRECISION NOT NULL, bill_validity_duration DATE NOT NULL, deposit_reduce DOUBLE PRECISION DEFAULT NULL, status VARCHAR(255) NOT NULL, payment_method VARCHAR(255) NOT NULL, payment_days VARCHAR(255) NOT NULL, payment_date_limit DATE NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_90651744979B1AD6 (company_id), INDEX IDX_906517449395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, customer_id INT NOT NULL, invoice_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, quote_number VARCHAR(255) NOT NULL, from_date DATE DEFAULT NULL, delivery_date DATE NOT NULL, total_price DOUBLE PRECISION NOT NULL, vat DOUBLE PRECISION NOT NULL, quote_validity_duration DATE NOT NULL, deposit DOUBLE PRECISION DEFAULT NULL, deposit_date DATE DEFAULT NULL, payment_method VARCHAR(255) NOT NULL, payment_days VARCHAR(255) NOT NULL, payment_date_limit DATE NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_474A8DB9979B1AD6 (company_id), INDEX IDX_474A8DB99395C3F3 (customer_id), INDEX IDX_474A8DB92989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, quotation_id INT NOT NULL, invoice_id INT NOT NULL, credit_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, quantity INT NOT NULL, quantity_type VARCHAR(255) NOT NULL, unit_cost DOUBLE PRECISION NOT NULL, total_price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_7332E169B4EA4E60 (quotation_id), INDEX IDX_7332E1692989F1FD (invoice_id), INDEX IDX_7332E169CE062FF9 (credit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB9979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB99395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB92989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E1692989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169CE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE979B1AD6');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE9395C3F3');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE2989F1FD');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744979B1AD6');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517449395C3F3');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB9979B1AD6');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB99395C3F3');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB92989F1FD');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169B4EA4E60');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1692989F1FD');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169CE062FF9');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE services');
    }
}
