<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512085748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD menus_id INT DEFAULT NULL, ADD burgers_id INT DEFAULT NULL, ADD complements_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F14041B84 FOREIGN KEY (menus_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1769E031 FOREIGN KEY (burgers_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FD1322E03 FOREIGN KEY (complements_id) REFERENCES complement (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F14041B84 ON image (menus_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F1769E031 ON image (burgers_id)');
        $this->addSql('CREATE INDEX IDX_C53D045FD1322E03 ON image (complements_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F14041B84');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F1769E031');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FD1322E03');
        $this->addSql('DROP INDEX IDX_C53D045F14041B84 ON image');
        $this->addSql('DROP INDEX IDX_C53D045F1769E031 ON image');
        $this->addSql('DROP INDEX IDX_C53D045FD1322E03 ON image');
        $this->addSql('ALTER TABLE image DROP menus_id, DROP burgers_id, DROP complements_id');
    }
}
