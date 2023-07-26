<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726061221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, billing_is_different TINYINT(1) NOT NULL, billing_address VARCHAR(255) DEFAULT NULL, billing_city VARCHAR(255) DEFAULT NULL, billing_postal_code VARCHAR(255) DEFAULT NULL, billing_country VARCHAR(255) DEFAULT NULL, siren_siret VARCHAR(255) NOT NULL, legal_form VARCHAR(255) DEFAULT NULL, rm_number VARCHAR(255) DEFAULT NULL, rcs_number VARCHAR(255) DEFAULT NULL, share_capital VARCHAR(255) DEFAULT NULL, city_registration VARCHAR(255) DEFAULT NULL, vat_id VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, description_work LONGTEXT DEFAULT NULL, gcs LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_4FBF094FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('DROP TABLE company');
    }
}
