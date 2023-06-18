<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615044343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // This up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users CHANGE is_verified is_verified TINYINT(1) DEFAULT 0, CHANGE status status VARCHAR(10) DEFAULT \'active\'');
    }

    public function down(Schema $schema): void
    {
        // This down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users CHANGE is_verified is_verified TINYINT(1) DEFAULT 0 NOT NULL, CHANGE status status VARCHAR(10) DEFAULT \'active\' NOT NULL');
    }
}
