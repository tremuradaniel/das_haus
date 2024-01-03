<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102103725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding currencies table + first currencies';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `currencies` (
            `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `code` VARCHAR(50) NOT NULL,
            `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
            PRIMARY KEY (`id`)
        );'
        );

        $this->addSql('INSERT INTO currencies (code, created, modified) 
            VALUES 
            ("RON", "2024-01-02 12:53:16", "2024-01-02 12:53:17"),
            ("EUR", "2024-01-02 12:53:16", "2024-01-02 12:53:17"),
            ("USD", "2024-01-02 12:53:16", "2024-01-02 12:53:17")
            ;'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE currencies');
    }
}
