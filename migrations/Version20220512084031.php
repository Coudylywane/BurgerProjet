<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512084031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD burgers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D1769E031 FOREIGN KEY (burgers_id) REFERENCES burger (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D1769E031 ON commande (burgers_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D1769E031');
        $this->addSql('DROP INDEX IDX_6EEAA67D1769E031 ON commande');
        $this->addSql('ALTER TABLE commande DROP burgers_id');
    }
}
