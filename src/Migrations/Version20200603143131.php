<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200603143131 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quartier CHANGE log log DOUBLE PRECISION DEFAULT NULL, CHANGE lat lat DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE image_id image_id INT DEFAULT NULL, CHANGE telephone telephone INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agence CHANGE image_logo_id image_logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A4CC8505A');
        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agence CHANGE image_logo_id image_logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A4CC8505A');
        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE quartier CHANGE log log DOUBLE PRECISION DEFAULT \'NULL\', CHANGE lat lat DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE image_id image_id INT DEFAULT NULL, CHANGE telephone telephone INT DEFAULT NULL');
    }
}
