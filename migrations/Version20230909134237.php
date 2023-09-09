<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230909134237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP billing_is_different, DROP billing_address, DROP billing_city, DROP billing_postal_code, DROP billing_country');
        $this->addSql('ALTER TABLE customer ADD vat_id VARCHAR(255) DEFAULT NULL, DROP address_line2, DROP company_address');
        $this->addSql('ALTER TABLE invoice DROP vat, DROP payment_days');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD billing_is_different TINYINT(1) NOT NULL, ADD billing_address VARCHAR(255) DEFAULT NULL, ADD billing_city VARCHAR(255) DEFAULT NULL, ADD billing_postal_code VARCHAR(255) DEFAULT NULL, ADD billing_country VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD company_address VARCHAR(255) DEFAULT NULL, CHANGE vat_id address_line2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice ADD vat DOUBLE PRECISION NOT NULL, ADD payment_days VARCHAR(255) NOT NULL');
    }
}
