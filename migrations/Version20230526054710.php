<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526054710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create trims table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE trims (id INT AUTO_INCREMENT NOT NULL, trim_id INT(11) NOT NULL, make_model_id INT(11) NOT NULL, product_id INT(11) NOT NULL, year INT(11) DEFAULT NULL, name varchar(11) DEFAULT NULL, description TEXT DEFAULT NULL, msrp INT(11) DEFAULT NULL, invoice INT(11) DEFAULT NULL, created_at DATETIME DEFAULT NULL, modified_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `trims`');
    }
}
