<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323083510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable_de_garde CHANGE id_unite_soin_id id_unite_soin_id INT DEFAULT NULL, CHANGE unite_soin unite_soin INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE responsable_de_garde CHANGE id_unite_soin_id id_unite_soin_id INT NOT NULL, CHANGE unite_soin unite_soin INT NOT NULL');
    }
}
