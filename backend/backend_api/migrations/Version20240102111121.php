<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240102111121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adding items_history table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `items_history` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `item_id` INT UNSIGNED NOT NULL,
            `date` DATE NOT NULL DEFAULT (CURRENT_DATE),
            `value` DECIMAL(20,2) UNSIGNED NOT NULL DEFAULT 0,
            `currency_id` TINYINT UNSIGNED NOT NULL,
            `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
            INDEX `item` (`item_id`),
            PRIMARY KEY (`id`),
            UNIQUE KEY `uq_item_date` (`item_id`,`date`) USING BTREE,
            CONSTRAINT `item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
            CONSTRAINT `currency` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
        )
        ;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE items_history');
    }
}
