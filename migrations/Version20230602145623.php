<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602145623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add created_at and modified_at column in table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `image` ADD `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `file`, ADD `modified_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `image` ADD `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `file`, ADD `modified_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`');

    }
}
