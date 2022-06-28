<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627085836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contents_meta CHANGE content_id content_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE contents_meta ADD CONSTRAINT FK_117AF5B19487CA85 FOREIGN KEY (content_id_id) REFERENCES contents (id)');
        $this->addSql('CREATE INDEX IDX_117AF5B19487CA85 ON contents_meta (content_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contents_meta DROP FOREIGN KEY FK_117AF5B19487CA85');
        $this->addSql('DROP INDEX IDX_117AF5B19487CA85 ON contents_meta');
        $this->addSql('ALTER TABLE contents_meta CHANGE content_id_id content_id INT NOT NULL');
    }
}
