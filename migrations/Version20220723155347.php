<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220723155347 extends AbstractMigration
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
        $this->addSql('ALTER TABLE balance ADD CONSTRAINT FK_ACF41FFED5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
        $this->addSql('ALTER TABLE balance_station ADD CONSTRAINT FK_ABD2DA0BAE91A3DD FOREIGN KEY (balance_id) REFERENCES balance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE balance_station ADD CONSTRAINT FK_ABD2DA0B21BDB235 FOREIGN KEY (station_id) REFERENCES station (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balance_station DROP FOREIGN KEY FK_ABD2DA0BAE91A3DD');
        $this->addSql('DROP TABLE balance');
        $this->addSql('DROP TABLE balance_station');
    }
}
