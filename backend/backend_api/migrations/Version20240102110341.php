<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102110341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding items table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("CREATE TABLE IF NOT EXISTS `items` (
            `id` int unsigned NOT NULL AUTO_INCREMENT,
            `user_site_id` int unsigned NOT NULL,
            `name` varchar(50) NOT NULL,
            `path` varchar(50) NOT NULL,
            `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
            `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_path_site` (`path`,`user_site_id`) USING BTREE,
            KEY `site` (`user_site_id`) USING BTREE,
            CONSTRAINT `user_site` FOREIGN KEY (`user_site_id`) REFERENCES `user_site` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
        );
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE items');
    }
}
