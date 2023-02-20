<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218065716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY IDX_31C154878BAC62AF');
        $this->addSql('ALTER TABLE metro DROP FOREIGN KEY IDX_3884E4E18BAC62AF');
        $this->addSql('ALTER TABLE neighborhood DROP FOREIGN KEY IDX_FEF1E9EE8BAC62AF');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY IDX_14B78418549213EC');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY IDX_8BF21CDE12469DE2');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY IDX_8BF21CDE2156041B');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY IDX_8BF21CDE803BB24B');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY IDX_8BF21CDE8BAC62AF');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY IDX_8BF21CDEB08FA272');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY IDX_8BF21CDEF675F31B');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY IDX_8BF21CDEF7D58AAA');
        $this->addSql('ALTER TABLE property_description DROP FOREIGN KEY FK_D2818010549213EC');
        $this->addSql('ALTER TABLE property_feature DROP FOREIGN KEY IDX_461A3F1E549213EC');
        $this->addSql('ALTER TABLE property_feature DROP FOREIGN KEY IDX_461A3F1E60E4B879');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE deal_type');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE metro');
        $this->addSql('DROP TABLE neighborhood');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_description');
        $this->addSql('DROP TABLE property_feature');
        $this->addSql('DROP INDEX UNIQ_1483A5E9F85E0677 ON users');
        $this->addSql('ALTER TABLE users ADD is_verified TINYINT(1) DEFAULT NULL, DROP username');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, meta_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, meta_description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, currency_title VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, symbol_left VARCHAR(12) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, symbol_right VARCHAR(12) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE deal_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_31C154878BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, icon LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE metro (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3884E4E18BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE neighborhood (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_FEF1E9EE8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sort_order INT DEFAULT NULL, INDEX IDX_14B78418549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, deal_type_id INT NOT NULL, category_id INT NOT NULL, city_id INT NOT NULL, neighborhood_id INT DEFAULT NULL, metro_station_id INT DEFAULT NULL, district_id INT DEFAULT NULL, slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, bathrooms_number SMALLINT DEFAULT NULL, bedrooms_number SMALLINT DEFAULT NULL, max_guests SMALLINT DEFAULT NULL, address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, latitude VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, longitude VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, show_map TINYINT(1) DEFAULT NULL, price INT DEFAULT NULL, price_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, available_now TINYINT(1) DEFAULT NULL, state VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'pending\' NOT NULL COLLATE `utf8mb4_unicode_ci`, priority_number INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX IDX_8BF21CDEF675F31B (author_id), INDEX IDX_8BF21CDE2156041B (deal_type_id), INDEX IDX_8BF21CDE12469DE2 (category_id), INDEX IDX_8BF21CDE8BAC62AF (city_id), INDEX IDX_8BF21CDE803BB24B (neighborhood_id), INDEX IDX_8BF21CDEF7D58AAA (metro_station_id), INDEX IDX_8BF21CDEB08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE property_description (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, meta_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, meta_description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_D2818010549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE property_feature (property_id INT NOT NULL, feature_id INT NOT NULL, INDEX IDX_461A3F1E549213EC (property_id), INDEX IDX_461A3F1E60E4B879 (feature_id), PRIMARY KEY(property_id, feature_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT IDX_31C154878BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE metro ADD CONSTRAINT IDX_3884E4E18BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE neighborhood ADD CONSTRAINT IDX_FEF1E9EE8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT IDX_14B78418549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT IDX_8BF21CDE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT IDX_8BF21CDE2156041B FOREIGN KEY (deal_type_id) REFERENCES deal_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT IDX_8BF21CDE803BB24B FOREIGN KEY (neighborhood_id) REFERENCES neighborhood (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT IDX_8BF21CDE8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT IDX_8BF21CDEB08FA272 FOREIGN KEY (district_id) REFERENCES district (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT IDX_8BF21CDEF675F31B FOREIGN KEY (author_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT IDX_8BF21CDEF7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property_description ADD CONSTRAINT FK_D2818010549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE property_feature ADD CONSTRAINT IDX_461A3F1E549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_feature ADD CONSTRAINT IDX_461A3F1E60E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD username VARCHAR(255) DEFAULT NULL, DROP is_verified');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }
}
