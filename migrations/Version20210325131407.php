<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325131407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planing_responsable_de_garde DROP FOREIGN KEY FK_D5DD9CE35E544CE5');
        $this->addSql('ALTER TABLE planing_unite_soin DROP FOREIGN KEY FK_84F4AD575E544CE5');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, date_heure_debut DATETIME NOT NULL, date_time_fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning_responsable_de_garde (planning_id INT NOT NULL, responsable_de_garde_id INT NOT NULL, INDEX IDX_28E2BCED3D865311 (planning_id), INDEX IDX_28E2BCED5914B491 (responsable_de_garde_id), PRIMARY KEY(planning_id, responsable_de_garde_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning_unite_soin (planning_id INT NOT NULL, unite_soin_id INT NOT NULL, INDEX IDX_EF27EB793D865311 (planning_id), INDEX IDX_EF27EB79D5FC60CA (unite_soin_id), PRIMARY KEY(planning_id, unite_soin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning_responsable_de_garde ADD CONSTRAINT FK_28E2BCED3D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning_responsable_de_garde ADD CONSTRAINT FK_28E2BCED5914B491 FOREIGN KEY (responsable_de_garde_id) REFERENCES responsable_de_garde (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning_unite_soin ADD CONSTRAINT FK_EF27EB793D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning_unite_soin ADD CONSTRAINT FK_EF27EB79D5FC60CA FOREIGN KEY (unite_soin_id) REFERENCES unite_soin (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE planing');
        $this->addSql('DROP TABLE planing_responsable_de_garde');
        $this->addSql('DROP TABLE planing_unite_soin');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning_responsable_de_garde DROP FOREIGN KEY FK_28E2BCED3D865311');
        $this->addSql('ALTER TABLE planning_unite_soin DROP FOREIGN KEY FK_EF27EB793D865311');
        $this->addSql('CREATE TABLE planing (id INT AUTO_INCREMENT NOT NULL, date_heure_debut DATETIME NOT NULL, date_time_fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planing_responsable_de_garde (planing_id INT NOT NULL, responsable_de_garde_id INT NOT NULL, INDEX IDX_D5DD9CE35E544CE5 (planing_id), INDEX IDX_D5DD9CE35914B491 (responsable_de_garde_id), PRIMARY KEY(planing_id, responsable_de_garde_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planing_unite_soin (planing_id INT NOT NULL, unite_soin_id INT NOT NULL, INDEX IDX_84F4AD575E544CE5 (planing_id), INDEX IDX_84F4AD57D5FC60CA (unite_soin_id), PRIMARY KEY(planing_id, unite_soin_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE planing_responsable_de_garde ADD CONSTRAINT FK_D5DD9CE35914B491 FOREIGN KEY (responsable_de_garde_id) REFERENCES responsable_de_garde (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planing_responsable_de_garde ADD CONSTRAINT FK_D5DD9CE35E544CE5 FOREIGN KEY (planing_id) REFERENCES planing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planing_unite_soin ADD CONSTRAINT FK_84F4AD575E544CE5 FOREIGN KEY (planing_id) REFERENCES planing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planing_unite_soin ADD CONSTRAINT FK_84F4AD57D5FC60CA FOREIGN KEY (unite_soin_id) REFERENCES unite_soin (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE planning_responsable_de_garde');
        $this->addSql('DROP TABLE planning_unite_soin');
    }
}
