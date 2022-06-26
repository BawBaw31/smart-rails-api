<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625225232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE visit_report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE visit_report (id INT NOT NULL, visit_type_id INT NOT NULL, writer_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEEF93B193C58854 ON visit_report (visit_type_id)');
        $this->addSql('CREATE INDEX IDX_FEEF93B11BC7E6B6 ON visit_report (writer_id)');
        $this->addSql('ALTER TABLE visit_report ADD CONSTRAINT FK_FEEF93B193C58854 FOREIGN KEY (visit_type_id) REFERENCES visit_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit_report ADD CONSTRAINT FK_FEEF93B11BC7E6B6 FOREIGN KEY (writer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit_value ADD visit_report_id INT NOT NULL');
        $this->addSql('ALTER TABLE visit_value ADD CONSTRAINT FK_68C2A355C80477D9 FOREIGN KEY (visit_report_id) REFERENCES visit_report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_68C2A355C80477D9 ON visit_value (visit_report_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE visit_value DROP CONSTRAINT FK_68C2A355C80477D9');
        $this->addSql('DROP SEQUENCE visit_report_id_seq CASCADE');
        $this->addSql('DROP TABLE visit_report');
        $this->addSql('DROP INDEX IDX_68C2A355C80477D9');
        $this->addSql('ALTER TABLE visit_value DROP visit_report_id');
    }
}
