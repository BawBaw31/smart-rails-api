<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628124248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE measure_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE visit_report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE visit_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE visit_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE measure (id INT NOT NULL, label VARCHAR(255) NOT NULL, theoretical_value DOUBLE PRECISION DEFAULT NULL, min_value DOUBLE PRECISION DEFAULT NULL, max_value DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE measure_visit_type (measure_id INT NOT NULL, visit_type_id INT NOT NULL, PRIMARY KEY(measure_id, visit_type_id))');
        $this->addSql('CREATE INDEX IDX_2BE73B375DA37D00 ON measure_visit_type (measure_id)');
        $this->addSql('CREATE INDEX IDX_2BE73B3793C58854 ON measure_visit_type (visit_type_id)');
        $this->addSql('CREATE TABLE visit_report (id INT NOT NULL, visit_type_id INT NOT NULL, writer_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEEF93B193C58854 ON visit_report (visit_type_id)');
        $this->addSql('CREATE INDEX IDX_FEEF93B11BC7E6B6 ON visit_report (writer_id)');
        $this->addSql('COMMENT ON COLUMN visit_report.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE visit_type (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE visit_value (id INT NOT NULL, measure_id INT NOT NULL, visit_report_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68C2A3555DA37D00 ON visit_value (measure_id)');
        $this->addSql('CREATE INDEX IDX_68C2A355C80477D9 ON visit_value (visit_report_id)');
        $this->addSql('ALTER TABLE measure_visit_type ADD CONSTRAINT FK_2BE73B375DA37D00 FOREIGN KEY (measure_id) REFERENCES measure (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE measure_visit_type ADD CONSTRAINT FK_2BE73B3793C58854 FOREIGN KEY (visit_type_id) REFERENCES visit_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit_report ADD CONSTRAINT FK_FEEF93B193C58854 FOREIGN KEY (visit_type_id) REFERENCES visit_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit_report ADD CONSTRAINT FK_FEEF93B11BC7E6B6 FOREIGN KEY (writer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit_value ADD CONSTRAINT FK_68C2A3555DA37D00 FOREIGN KEY (measure_id) REFERENCES measure (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit_value ADD CONSTRAINT FK_68C2A355C80477D9 FOREIGN KEY (visit_report_id) REFERENCES visit_report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE measure_visit_type DROP CONSTRAINT FK_2BE73B375DA37D00');
        $this->addSql('ALTER TABLE visit_value DROP CONSTRAINT FK_68C2A3555DA37D00');
        $this->addSql('ALTER TABLE visit_value DROP CONSTRAINT FK_68C2A355C80477D9');
        $this->addSql('ALTER TABLE measure_visit_type DROP CONSTRAINT FK_2BE73B3793C58854');
        $this->addSql('ALTER TABLE visit_report DROP CONSTRAINT FK_FEEF93B193C58854');
        $this->addSql('DROP SEQUENCE measure_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE visit_report_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE visit_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE visit_value_id_seq CASCADE');
        $this->addSql('DROP TABLE measure');
        $this->addSql('DROP TABLE measure_visit_type');
        $this->addSql('DROP TABLE visit_report');
        $this->addSql('DROP TABLE visit_type');
        $this->addSql('DROP TABLE visit_value');
    }
}
