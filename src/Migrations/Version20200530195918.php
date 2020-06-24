<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530195918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quartier CHANGE offre_id offre_id INT DEFAULT NULL, CHANGE log log DOUBLE PRECISION DEFAULT NULL, CHANGE lat lat DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE telephone telephone INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `admin`');
        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier CHANGE offre_id offre_id INT DEFAULT NULL, CHANGE log log DOUBLE PRECISION DEFAULT \'NULL\', CHANGE lat lat DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE telephone telephone INT DEFAULT NULL');
    }
}
