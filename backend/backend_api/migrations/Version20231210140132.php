<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231210140132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'added sites table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
        CREATE TABLE IF NOT EXISTS `sites` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) CHARACTER SET utf8 NOT NULL,
            `domain` varchar(255) NOT NULL,
            `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
            `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `domain` (`domain`),
            UNIQUE KEY `name` (`name`)
          )        
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE sites');
    }
}
