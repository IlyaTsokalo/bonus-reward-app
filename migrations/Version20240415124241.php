<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415124241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bonus_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE customer_bonus_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bonus (id INT NOT NULL, name VARCHAR(255) NOT NULL, reward_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, roles JSON NOT NULL, is_email_verified BOOLEAN DEFAULT NULL, is_birthday BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_ID ON customer (id)');
        $this->addSql('CREATE TABLE customer_bonus (id INT NOT NULL, customer_id INT NOT NULL, bonus_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_51AD0A419395C3F3 ON customer_bonus (customer_id)');
        $this->addSql('CREATE INDEX IDX_51AD0A4169545666 ON customer_bonus (bonus_id)');
        $this->addSql('COMMENT ON COLUMN customer_bonus.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE customer_bonus ADD CONSTRAINT FK_51AD0A419395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_bonus ADD CONSTRAINT FK_51AD0A4169545666 FOREIGN KEY (bonus_id) REFERENCES bonus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE bonus_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE customer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE customer_bonus_id_seq CASCADE');
        $this->addSql('ALTER TABLE customer_bonus DROP CONSTRAINT FK_51AD0A419395C3F3');
        $this->addSql('ALTER TABLE customer_bonus DROP CONSTRAINT FK_51AD0A4169545666');
        $this->addSql('DROP TABLE bonus');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_bonus');
    }
}
