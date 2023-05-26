<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524104907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Allow initially password NULL for the staff invitation';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `users` CHANGE `password` `password` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
    }
}
