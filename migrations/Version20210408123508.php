<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408123508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE planning_responsable_de_garde');
        $this->addSql('DROP TABLE planning_unite_soin');
        $this->addSql('DROP TABLE plannings');
        $this->addSql('ALTER TABLE responsable_de_garde DROP FOREIGN KEY FK_F2C978236BD4B1AF');
        $this->addSql('DROP INDEX IDX_F2C978236BD4B1AF ON responsable_de_garde');
        $this->addSql('ALTER TABLE responsable_de_garde DROP id_unite_soin_id, DROP unite_soin');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planning_responsable_de_garde (planning_id INT NOT NULL, responsable_de_garde_id INT NOT NULL, INDEX IDX_28E2BCED3D865311 (planning_id), INDEX IDX_28E2BCED5914B491 (responsable_de_garde_id), PRIMARY KEY(planning_id, responsable_de_garde_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planning_unite_soin (planning_id INT NOT NULL, unite_soin_id INT NOT NULL, INDEX IDX_EF27EB793D865311 (planning_id), INDEX IDX_EF27EB79D5FC60CA (unite_soin_id), PRIMARY KEY(planning_id, unite_soin_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE plannings (id INT AUTO_INCREMENT NOT NULL, unite INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE planning_responsable_de_garde ADD CONSTRAINT FK_28E2BCED3D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning_responsable_de_garde ADD CONSTRAINT FK_28E2BCED5914B491 FOREIGN KEY (responsable_de_garde_id) REFERENCES responsable_de_garde (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning_unite_soin ADD CONSTRAINT FK_EF27EB793D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planning_unite_soin ADD CONSTRAINT FK_EF27EB79D5FC60CA FOREIGN KEY (unite_soin_id) REFERENCES unite_soin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsable_de_garde ADD id_unite_soin_id INT DEFAULT NULL, ADD unite_soin INT DEFAULT NULL');
        $this->addSql('ALTER TABLE responsable_de_garde ADD CONSTRAINT FK_F2C978236BD4B1AF FOREIGN KEY (id_unite_soin_id) REFERENCES unite_soin (id)');
        $this->addSql('CREATE INDEX IDX_F2C978236BD4B1AF ON responsable_de_garde (id_unite_soin_id)');
    }
}
