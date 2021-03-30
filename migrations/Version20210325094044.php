<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325094044 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planing (id INT AUTO_INCREMENT NOT NULL, date_heure_debut DATETIME NOT NULL, date_time_fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planing_responsable_de_garde (planing_id INT NOT NULL, responsable_de_garde_id INT NOT NULL, INDEX IDX_D5DD9CE35E544CE5 (planing_id), INDEX IDX_D5DD9CE35914B491 (responsable_de_garde_id), PRIMARY KEY(planing_id, responsable_de_garde_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planing_unite_soin (planing_id INT NOT NULL, unite_soin_id INT NOT NULL, INDEX IDX_84F4AD575E544CE5 (planing_id), INDEX IDX_84F4AD57D5FC60CA (unite_soin_id), PRIMARY KEY(planing_id, unite_soin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planing_responsable_de_garde ADD CONSTRAINT FK_D5DD9CE35E544CE5 FOREIGN KEY (planing_id) REFERENCES planing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planing_responsable_de_garde ADD CONSTRAINT FK_D5DD9CE35914B491 FOREIGN KEY (responsable_de_garde_id) REFERENCES responsable_de_garde (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planing_unite_soin ADD CONSTRAINT FK_84F4AD575E544CE5 FOREIGN KEY (planing_id) REFERENCES planing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planing_unite_soin ADD CONSTRAINT FK_84F4AD57D5FC60CA FOREIGN KEY (unite_soin_id) REFERENCES unite_soin (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planing_responsable_de_garde DROP FOREIGN KEY FK_D5DD9CE35E544CE5');
        $this->addSql('ALTER TABLE planing_unite_soin DROP FOREIGN KEY FK_84F4AD575E544CE5');
        $this->addSql('DROP TABLE planing');
        $this->addSql('DROP TABLE planing_responsable_de_garde');
        $this->addSql('DROP TABLE planing_unite_soin');
    }
}
