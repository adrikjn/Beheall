<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731111356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice ADD quotation_id INT DEFAULT NULL, CHANGE deelivery_date delivery_date DATE NOT NULL');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_90651744B4EA4E60 ON invoice (quotation_id)');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB92989F1FD');
        $this->addSql('DROP INDEX IDX_474A8DB92989F1FD ON quotation');
        $this->addSql('ALTER TABLE quotation DROP invoice_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744B4EA4E60');
        $this->addSql('DROP INDEX UNIQ_90651744B4EA4E60 ON invoice');
        $this->addSql('ALTER TABLE invoice DROP quotation_id, CHANGE delivery_date deelivery_date DATE NOT NULL');
        $this->addSql('ALTER TABLE quotation ADD invoice_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB92989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('CREATE INDEX IDX_474A8DB92989F1FD ON quotation (invoice_id)');
    }
}
