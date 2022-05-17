<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512085413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complement_burger (complement_id INT NOT NULL, burger_id INT NOT NULL, INDEX IDX_B555583A40D9D0AA (complement_id), INDEX IDX_B555583A17CE5090 (burger_id), PRIMARY KEY(complement_id, burger_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE complement_burger ADD CONSTRAINT FK_B555583A40D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement_burger ADD CONSTRAINT FK_B555583A17CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE complement_burger');
    }
}
