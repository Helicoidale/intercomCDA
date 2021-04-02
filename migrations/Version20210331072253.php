<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331072253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plannings (id INT AUTO_INCREMENT NOT NULL, unite INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning ADD date DATE NOT NULL, CHANGE date_heure_debut date_heure_debut TIME NOT NULL, CHANGE date_time_fin date_time_fin TIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE plannings');
        $this->addSql('ALTER TABLE planning DROP date, CHANGE date_heure_debut date_heure_debut DATETIME NOT NULL, CHANGE date_time_fin date_time_fin DATETIME NOT NULL');
    }
}
