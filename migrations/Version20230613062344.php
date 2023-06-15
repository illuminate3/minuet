<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613062344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account ADD stripe_customer_id VARCHAR(32) NOT NULL, ADD is_expiring TINYINT(1) DEFAULT 0 NOT NULL, ADD is_past_due TINYINT(1) DEFAULT 0 NOT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', ADD modified_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT \'(DC2Type:datetimetz_immutable)\', CHANGE is_subscription_active is_subscription_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD frequency VARCHAR(45) DEFAULT NULL, ADD slug VARCHAR(255) DEFAULT NULL, CHANGE support support VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users DROP stripe_customer_id, DROP stripe_subscription_id, DROP is_subscription_active');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD stripe_customer_id VARCHAR(255) DEFAULT NULL, ADD stripe_subscription_id VARCHAR(255) DEFAULT NULL, ADD is_subscription_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE account DROP stripe_customer_id, DROP is_expiring, DROP is_past_due, DROP created_at, DROP modified_at, CHANGE is_subscription_active is_subscription_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription DROP frequency, DROP slug, CHANGE support support VARCHAR(20) DEFAULT NULL');
    }
}
