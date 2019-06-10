<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190509135719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact (pseudo INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(pseudo)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('ALTER TABLE event ADD titre VARCHAR(255) NOT NULL, ADD confirmation TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, bar_id INT NOT NULL, jour DATETIME NOT NULL, tranche_horaire1 TINYINT(1) NOT NULL, tranche_horaire2 TINYINT(1) NOT NULL, tranche_horaire3 TINYINT(1) NOT NULL, tranche_horaire4 TINYINT(1) NOT NULL, tranche_horaire5 TINYINT(1) NOT NULL, tranche_horaire6 TINYINT(1) NOT NULL, tranche_horaire7 TINYINT(1) NOT NULL, tranche_horaire8 TINYINT(1) NOT NULL, tranche_horaire9 TINYINT(1) NOT NULL, tranche_horaire10 TINYINT(1) NOT NULL, tranche_horaire11 TINYINT(1) NOT NULL, tranche_horaire12 TINYINT(1) NOT NULL, tranche_horaire13 TINYINT(1) NOT NULL, tranche_horaire14 TINYINT(1) NOT NULL, tranche_horaire15 TINYINT(1) NOT NULL, tranche_horaire16 TINYINT(1) NOT NULL, tranche_horaire17 TINYINT(1) NOT NULL, tranche_horaire18 TINYINT(1) NOT NULL, tranche_horaire19 TINYINT(1) NOT NULL, tranche_horaire20 TINYINT(1) NOT NULL, tranche_horaire21 TINYINT(1) NOT NULL, tranche_horaire22 TINYINT(1) NOT NULL, tranche_horaire23 TINYINT(1) NOT NULL, tranche_horaire24 TINYINT(1) NOT NULL, INDEX IDX_BBC83DB689A253A (bar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE horaire ADD CONSTRAINT FK_BBC83DB689A253A FOREIGN KEY (bar_id) REFERENCES bar (id)');
        $this->addSql('DROP TABLE contact');
        $this->addSql('ALTER TABLE event DROP titre, DROP confirmation');
    }
}
