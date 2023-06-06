<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603183601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, subscription_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, primary_user INT NOT NULL, UNIQUE INDEX UNIQ_7D3656A45E237E06 (name), UNIQUE INDEX UNIQ_7D3656A424008981 (primary_user), INDEX IDX_7D3656A49A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_user (account_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_10051E39B6B5FBA (account_id), INDEX IDX_10051E3A76ED395 (user_id), PRIMARY KEY(account_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, category_order INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, sort_order SMALLINT DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, INDEX IDX_C53D045F4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE make_model (id INT AUTO_INCREMENT NOT NULL, year VARCHAR(4) NOT NULL, make VARCHAR(45) NOT NULL, model VARCHAR(255) NOT NULL, body_style VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(2) DEFAULT \'en\' NOT NULL, sort_order SMALLINT DEFAULT NULL, url VARCHAR(255) NOT NULL, is_slug TINYINT(1) DEFAULT NULL, nofollow TINYINT(1) DEFAULT NULL, new_tab TINYINT(1) DEFAULT NULL, UNIQUE INDEX url_title_unique_key (url, title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, updated_by INT DEFAULT NULL, user_id INT DEFAULT NULL, thread_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B6BD307F16FE72E1 (updated_by), INDEX IDX_B6BD307FA76ED395 (user_id), INDEX IDX_B6BD307FE2904019 (thread_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reference VARCHAR(20) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_F5299398AEA34913 (reference), INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, price INT NOT NULL, INDEX IDX_ED896F468D9F6D38 (order_id), INDEX IDX_ED896F464584665A (product_id), PRIMARY KEY(order_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, locale VARCHAR(2) DEFAULT \'en\' NOT NULL, content LONGTEXT DEFAULT NULL, show_in_menu TINYINT(1) DEFAULT NULL, publish TINYINT(1) DEFAULT NULL, UNIQUE INDEX slug_title_unique_key (slug, title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, account_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, first_name VARCHAR(40) DEFAULT NULL, last_name VARCHAR(40) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, address_street VARCHAR(255) DEFAULT NULL, address_unit VARCHAR(255) DEFAULT NULL, state VARCHAR(2) DEFAULT NULL, city VARCHAR(20) DEFAULT NULL, post_code VARCHAR(10) DEFAULT NULL, display_email VARCHAR(40) DEFAULT NULL, website VARCHAR(40) DEFAULT NULL, facebook VARCHAR(100) DEFAULT NULL, twitter VARCHAR(100) DEFAULT NULL, linkedin VARCHAR(100) DEFAULT NULL, instagram VARCHAR(100) DEFAULT NULL, pinterest VARCHAR(100) DEFAULT NULL, youtube VARCHAR(100) DEFAULT NULL, banner VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, setting_name VARCHAR(191) NOT NULL, setting_value LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_E545A0C59F9752E0 (setting_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, plan VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, valid_until VARCHAR(20) NOT NULL, availability VARCHAR(20) DEFAULT NULL, support VARCHAR(20) DEFAULT NULL, stripe_price_id VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, account_id INT DEFAULT NULL, is_closed TINYINT(1) DEFAULT 0, is_pin TINYINT(1) DEFAULT 0, total_messages SMALLINT DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_31204C834584665A (product_id), INDEX IDX_31204C83A76ED395 (user_id), INDEX IDX_31204C839B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', confirmation_token VARCHAR(255) DEFAULT NULL, stripe_customer_id VARCHAR(255) DEFAULT NULL, stripe_subscription_id VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, email_verified_at DATETIME DEFAULT NULL, is_verified TINYINT(1) DEFAULT NULL, is_account TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A49A1887DC9A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE account_user ADD CONSTRAINT FK_10051E39B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE account_user ADD CONSTRAINT FK_10051E3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F16FE72E1 FOREIGN KEY (updated_by) REFERENCES users (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F468D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F464584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C834584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C839B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
