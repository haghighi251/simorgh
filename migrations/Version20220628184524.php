<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628184524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BB84A0A3ED');
        $this->addSql('DROP INDEX IDX_795FD9BB84A0A3ED ON attachment');
        $this->addSql('ALTER TABLE attachment CHANGE content_id contents_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BB394E8343 FOREIGN KEY (contents_id) REFERENCES contents (id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB394E8343 ON attachment (contents_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BB394E8343');
        $this->addSql('DROP INDEX IDX_795FD9BB394E8343 ON attachment');
        $this->addSql('ALTER TABLE attachment CHANGE contents_id content_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BB84A0A3ED FOREIGN KEY (content_id) REFERENCES contents (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_795FD9BB84A0A3ED ON attachment (content_id)');
    }
}
