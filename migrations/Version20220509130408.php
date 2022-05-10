<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509130408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD nom VARCHAR(255) DEFAULT NULL, ADD prenom VARCHAR(255) DEFAULT NULL, ADD telephone INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gestionnaire ADD nom VARCHAR(255) DEFAULT NULL, ADD prenom VARCHAR(255) DEFAULT NULL, ADD telephone INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) DEFAULT NULL, ADD prenom VARCHAR(255) DEFAULT NULL, ADD telephone INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP nom, DROP prenom, DROP telephone');
        $this->addSql('ALTER TABLE gestionnaire DROP nom, DROP prenom, DROP telephone');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP telephone');
    }
}
