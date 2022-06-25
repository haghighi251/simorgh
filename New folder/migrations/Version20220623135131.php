<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623135131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contents_categories (contents_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_17A98AEF394E8343 (contents_id), INDEX IDX_17A98AEFA21214B7 (categories_id), PRIMARY KEY(contents_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contents_categories ADD CONSTRAINT FK_17A98AEF394E8343 FOREIGN KEY (contents_id) REFERENCES contents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contents_categories ADD CONSTRAINT FK_17A98AEFA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A9487CA85');
        $this->addSql('DROP INDEX IDX_5F9E962A9487CA85 ON comments');
        $this->addSql('ALTER TABLE comments CHANGE content_id content_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A9487CA85 FOREIGN KEY (content_id) REFERENCES contents (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A9487CA85 ON comments (content_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contents_categories');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A9487CA85');
        $this->addSql('DROP INDEX IDX_5F9E962A9487CA85 ON comments');
        $this->addSql('ALTER TABLE comments CHANGE content_id content_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A9487CA85 FOREIGN KEY (content_id) REFERENCES contents (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5F9E962A9487CA85 ON comments (content_id)');
    }
}
