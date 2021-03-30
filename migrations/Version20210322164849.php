<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322164849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE responsable_de_garde (id INT AUTO_INCREMENT NOT NULL, id_unite_soin_id INT NOT NULL, nom VARCHAR(255) NOT NULL, unite_soin INT NOT NULL, tel_consultation VARCHAR(255) DEFAULT NULL, tel_domicile VARCHAR(255) DEFAULT NULL, tel_portable VARCHAR(255) DEFAULT NULL, INDEX IDX_F2C978236BD4B1AF (id_unite_soin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE responsable_de_garde ADD CONSTRAINT FK_F2C978236BD4B1AF FOREIGN KEY (id_unite_soin_id) REFERENCES unite_soin (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE responsable_de_garde');
    }
}
