<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231210145402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add user_site pivot table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS `user_site` (
            `id` int unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int unsigned NOT NULL,
            `site_id` int unsigned NOT NULL,
            `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uq_user_site` (`site_id`,`user_id`),
            KEY `IDX_13C2452D9D86650F` (`user_id`) USING BTREE,
            KEY `IDX_13C2452DBB1E4E52` (`site_id`) USING BTREE,
            CONSTRAINT `site` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE RESTRICT,
            CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT
          )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user_site');
    }
}
