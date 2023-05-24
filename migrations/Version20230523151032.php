<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523151032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add dealer id in users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD dealer_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `users` DROP dealer_id');
    }
}
