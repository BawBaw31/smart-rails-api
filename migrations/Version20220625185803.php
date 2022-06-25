<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625185803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visit_value DROP CONSTRAINT fk_68c2a35575fa0ff2');
        $this->addSql('DROP SEQUENCE visit_id_seq CASCADE');
        $this->addSql('DROP TABLE visit');
        $this->addSql('ALTER TABLE measure RENAME COLUMN theoretical_value TO theorical_value');
        $this->addSql('DROP INDEX idx_68c2a35575fa0ff2');
        $this->addSql('ALTER TABLE visit_value DROP visit_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE visit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE visit (id INT NOT NULL, visit_type_id INT NOT NULL, label VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_437ee93993c58854 ON visit (visit_type_id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT fk_437ee93993c58854 FOREIGN KEY (visit_type_id) REFERENCES visit_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE measure RENAME COLUMN theorical_value TO theoretical_value');
        $this->addSql('ALTER TABLE visit_value ADD visit_id INT NOT NULL');
        $this->addSql('ALTER TABLE visit_value ADD CONSTRAINT fk_68c2a35575fa0ff2 FOREIGN KEY (visit_id) REFERENCES visit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_68c2a35575fa0ff2 ON visit_value (visit_id)');
    }
}
