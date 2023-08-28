<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828141252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169CE062FF9');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169B4EA4E60');
        $this->addSql('DROP INDEX IDX_7332E169B4EA4E60 ON services');
        $this->addSql('DROP INDEX IDX_7332E169CE062FF9 ON services');
        $this->addSql('ALTER TABLE services DROP quotation_id, DROP credit_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services ADD quotation_id INT NOT NULL, ADD credit_id INT NOT NULL');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169CE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('CREATE INDEX IDX_7332E169B4EA4E60 ON services (quotation_id)');
        $this->addSql('CREATE INDEX IDX_7332E169CE062FF9 ON services (credit_id)');
    }
}
