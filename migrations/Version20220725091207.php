<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220725091207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE balance (id INT AUTO_INCREMENT NOT NULL, bike_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_ACF41FFED5A4816F (bike_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE balance_station (balance_id INT NOT NULL, station_id INT NOT NULL, INDEX IDX_ABD2DA0BAE91A3DD (balance_id), INDEX IDX_ABD2DA0B21BDB235 (station_id), PRIMARY KEY(balance_id, station_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bike (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, availablity VARCHAR(30) NOT NULL, lat VARCHAR(50) DEFAULT NULL, lng VARCHAR(50) DEFAULT NULL, reference VARCHAR(50) DEFAULT NULL, number VARCHAR(4) NOT NULL, rate VARCHAR(1) NOT NULL, purchased_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, main_picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_B12D4A3621BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_bike (inventory_id INT NOT NULL, bike_id INT NOT NULL, INDEX IDX_61AF8AE9EEA759 (inventory_id), INDEX IDX_61AF8AED5A4816F (bike_id), PRIMARY KEY(inventory_id, bike_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(50) DEFAULT NULL, name VARCHAR(150) NOT NULL, short_description LONGTEXT DEFAULT NULL, long_description LONGTEXT DEFAULT NULL, status TINYINT(1) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, main_picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair_act (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, bike_id INT DEFAULT NULL, repair_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_E979F16621BDB235 (station_id), INDEX IDX_E979F166D5A4816F (bike_id), INDEX IDX_E979F16643833CFF (repair_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, number VARCHAR(3) DEFAULT NULL, reference VARCHAR(50) DEFAULT NULL, capacity VARCHAR(3) DEFAULT NULL, name VARCHAR(150) NOT NULL, address VARCHAR(255) NOT NULL, zip VARCHAR(5) NOT NULL, city VARCHAR(50) NOT NULL, lat VARCHAR(50) DEFAULT NULL, lng VARCHAR(50) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, main_picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, roles JSON NOT NULL, email VARCHAR(180) NOT NULL, is_verified TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, company VARCHAR(50) NOT NULL, job VARCHAR(30) NOT NULL, first_name VARCHAR(70) NOT NULL, last_name VARCHAR(70) NOT NULL, address VARCHAR(255) NOT NULL, zip VARCHAR(5) NOT NULL, city VARCHAR(50) NOT NULL, phone VARCHAR(20) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, main_picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vandalism (id INT AUTO_INCREMENT NOT NULL, bike_id INT DEFAULT NULL, station_id INT DEFAULT NULL, content LONGTEXT NOT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', main_picture VARCHAR(255) DEFAULT NULL, INDEX IDX_94A8A519D5A4816F (bike_id), INDEX IDX_94A8A51921BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rememberme_token (series VARCHAR(88) NOT NULL, value VARCHAR(88) NOT NULL, lastUsed DATETIME NOT NULL, class VARCHAR(100) NOT NULL, username VARCHAR(200) NOT NULL, PRIMARY KEY(series)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE balance ADD CONSTRAINT FK_ACF41FFED5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
        $this->addSql('ALTER TABLE balance_station ADD CONSTRAINT FK_ABD2DA0BAE91A3DD FOREIGN KEY (balance_id) REFERENCES balance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE balance_station ADD CONSTRAINT FK_ABD2DA0B21BDB235 FOREIGN KEY (station_id) REFERENCES station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A3621BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE inventory_bike ADD CONSTRAINT FK_61AF8AE9EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_bike ADD CONSTRAINT FK_61AF8AED5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE repair_act ADD CONSTRAINT FK_E979F16621BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE repair_act ADD CONSTRAINT FK_E979F166D5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
        $this->addSql('ALTER TABLE repair_act ADD CONSTRAINT FK_E979F16643833CFF FOREIGN KEY (repair_id) REFERENCES repair (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vandalism ADD CONSTRAINT FK_94A8A519D5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
        $this->addSql('ALTER TABLE vandalism ADD CONSTRAINT FK_94A8A51921BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balance_station DROP FOREIGN KEY FK_ABD2DA0BAE91A3DD');
        $this->addSql('ALTER TABLE balance DROP FOREIGN KEY FK_ACF41FFED5A4816F');
        $this->addSql('ALTER TABLE inventory_bike DROP FOREIGN KEY FK_61AF8AED5A4816F');
        $this->addSql('ALTER TABLE repair_act DROP FOREIGN KEY FK_E979F166D5A4816F');
        $this->addSql('ALTER TABLE vandalism DROP FOREIGN KEY FK_94A8A519D5A4816F');
        $this->addSql('ALTER TABLE inventory_bike DROP FOREIGN KEY FK_61AF8AE9EEA759');
        $this->addSql('ALTER TABLE repair_act DROP FOREIGN KEY FK_E979F16643833CFF');
        $this->addSql('ALTER TABLE balance_station DROP FOREIGN KEY FK_ABD2DA0B21BDB235');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A3621BDB235');
        $this->addSql('ALTER TABLE repair_act DROP FOREIGN KEY FK_E979F16621BDB235');
        $this->addSql('ALTER TABLE vandalism DROP FOREIGN KEY FK_94A8A51921BDB235');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE balance');
        $this->addSql('DROP TABLE balance_station');
        $this->addSql('DROP TABLE bike');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE inventory_bike');
        $this->addSql('DROP TABLE repair');
        $this->addSql('DROP TABLE repair_act');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vandalism');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE rememberme_token');
    }
}
