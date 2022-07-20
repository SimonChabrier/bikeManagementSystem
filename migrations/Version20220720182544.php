<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720182544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vandalism ADD bike_id INT DEFAULT NULL, ADD station_id INT DEFAULT NULL, ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE vandalism ADD CONSTRAINT FK_94A8A519D5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
        $this->addSql('ALTER TABLE vandalism ADD CONSTRAINT FK_94A8A51921BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('CREATE INDEX IDX_94A8A519D5A4816F ON vandalism (bike_id)');
        $this->addSql('CREATE INDEX IDX_94A8A51921BDB235 ON vandalism (station_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vandalism DROP FOREIGN KEY FK_94A8A519D5A4816F');
        $this->addSql('ALTER TABLE vandalism DROP FOREIGN KEY FK_94A8A51921BDB235');
        $this->addSql('DROP INDEX IDX_94A8A519D5A4816F ON vandalism');
        $this->addSql('DROP INDEX IDX_94A8A51921BDB235 ON vandalism');
        $this->addSql('ALTER TABLE vandalism DROP bike_id, DROP station_id, DROP status');
    }
}
