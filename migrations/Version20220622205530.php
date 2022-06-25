<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622205530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contents (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(200) NOT NULL, content LONGTEXT NOT NULL, content_status VARCHAR(15) NOT NULL, comment_status VARCHAR(10) NOT NULL, content_slug VARCHAR(255) NOT NULL, content_password VARCHAR(255) DEFAULT NULL, content_type VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_B4FA1177F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA1177F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE categories CHANGE parent parent INT DEFAULT NULL, CHANGE level level INT DEFAULT 0');
        $this->addSql('ALTER TABLE comments ADD content_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A9487CA85 FOREIGN KEY (content_id_id) REFERENCES contents (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A9487CA85 ON comments (content_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A9487CA85');
        $this->addSql('DROP TABLE contents');
        $this->addSql('ALTER TABLE categories CHANGE parent parent INT DEFAULT 0 NOT NULL, CHANGE level level INT NOT NULL');
        $this->addSql('DROP INDEX IDX_5F9E962A9487CA85 ON comments');
        $this->addSql('ALTER TABLE comments DROP content_id_id');
    }
}
