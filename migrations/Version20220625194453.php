<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625194453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, event_name VARCHAR(50) NOT NULL, request_type_v1 VARCHAR(100) DEFAULT NULL, request_type_v2 VARCHAR(100) DEFAULT NULL, request_method VARCHAR(50) NOT NULL, base_url VARCHAR(255) NOT NULL, uri_path_info VARCHAR(255) NOT NULL, uri_query_string VARCHAR(255) NOT NULL, full_uri VARCHAR(300) NOT NULL, method_correct VARCHAR(20) NOT NULL, uri_age_param_set VARCHAR(10) NOT NULL, controller VARCHAR(50) NOT NULL, router VARCHAR(30) NOT NULL, client_ip VARCHAR(25) NOT NULL, router_parameters VARCHAR(200) DEFAULT NULL, json_data VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE log');
    }
}
