<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523210802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE automobile_history DROP FOREIGN KEY FK_F4D22E9A1C360D33');
        $this->addSql('DROP INDEX IDX_F4D22E9A1C360D33 ON automobile_history');
        $this->addSql('ALTER TABLE automobile_history ADD n_immatriculation VARCHAR(255) NOT NULL, DROP n_immatriculation_id, CHANGE date date VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE automobile_history ADD n_immatriculation_id INT NOT NULL, DROP n_immatriculation, CHANGE date date VARCHAR(225) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE automobile_history ADD CONSTRAINT FK_F4D22E9A1C360D33 FOREIGN KEY (n_immatriculation_id) REFERENCES automobile (id)');
        $this->addSql('CREATE INDEX IDX_F4D22E9A1C360D33 ON automobile_history (n_immatriculation_id)');
    }
}
