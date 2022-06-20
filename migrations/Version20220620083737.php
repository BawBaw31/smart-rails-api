<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620083737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE measure_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE visit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE visit_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE visit_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE measure (id INT NOT NULL, label VARCHAR(255) NOT NULL, theoretical_value DOUBLE PRECISION DEFAULT NULL, min_value DOUBLE PRECISION DEFAULT NULL, max_value DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE measure_visit_type (measure_id INT NOT NULL, visit_type_id INT NOT NULL, PRIMARY KEY(measure_id, visit_type_id))');
        $this->addSql('CREATE INDEX IDX_2BE73B375DA37D00 ON measure_visit_type (measure_id)');
        $this->addSql('CREATE INDEX IDX_2BE73B3793C58854 ON measure_visit_type (visit_type_id)');
        $this->addSql('CREATE TABLE visit (id INT NOT NULL, visit_type_id INT NOT NULL, label VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_437EE93993C58854 ON visit (visit_type_id)');
        $this->addSql('CREATE TABLE visit_type (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE visit_value (id INT NOT NULL, visit_id INT NOT NULL, measure_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68C2A35575FA0FF2 ON visit_value (visit_id)');
        $this->addSql('CREATE INDEX IDX_68C2A3555DA37D00 ON visit_value (measure_id)');
        $this->addSql('ALTER TABLE measure_visit_type ADD CONSTRAINT FK_2BE73B375DA37D00 FOREIGN KEY (measure_id) REFERENCES measure (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE measure_visit_type ADD CONSTRAINT FK_2BE73B3793C58854 FOREIGN KEY (visit_type_id) REFERENCES visit_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE93993C58854 FOREIGN KEY (visit_type_id) REFERENCES visit_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit_value ADD CONSTRAINT FK_68C2A35575FA0FF2 FOREIGN KEY (visit_id) REFERENCES visit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visit_value ADD CONSTRAINT FK_68C2A3555DA37D00 FOREIGN KEY (measure_id) REFERENCES measure (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE document');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE measure_visit_type DROP CONSTRAINT FK_2BE73B375DA37D00');
        $this->addSql('ALTER TABLE visit_value DROP CONSTRAINT FK_68C2A3555DA37D00');
        $this->addSql('ALTER TABLE visit_value DROP CONSTRAINT FK_68C2A35575FA0FF2');
        $this->addSql('ALTER TABLE measure_visit_type DROP CONSTRAINT FK_2BE73B3793C58854');
        $this->addSql('ALTER TABLE visit DROP CONSTRAINT FK_437EE93993C58854');
        $this->addSql('DROP SEQUENCE measure_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE visit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE visit_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE visit_value_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE document (id INT NOT NULL, csv_name VARCHAR(255) NOT NULL, csv_size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE measure');
        $this->addSql('DROP TABLE measure_visit_type');
        $this->addSql('DROP TABLE visit');
        $this->addSql('DROP TABLE visit_type');
        $this->addSql('DROP TABLE visit_value');
    }
}
