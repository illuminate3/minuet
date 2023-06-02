<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601062322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename table trims to product_trims';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trims RENAME product_trims');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trims RENAME product_trims');

    }
}
