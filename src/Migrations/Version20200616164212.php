<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200616164212 extends AbstractMigration
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
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9DD44EDDC');
        $this->addSql('DROP INDEX UNIQ_64C19AA9DD44EDDC ON agence');
        $this->addSql('ALTER TABLE agence DROP vendeur_r_id, CHANGE image_logo_id image_logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agence ADD vendeur_r_id INT NOT NULL, CHANGE image_logo_id image_logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9DD44EDDC FOREIGN KEY (vendeur_r_id) REFERENCES vendeur_regulier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19AA9DD44EDDC ON agence (vendeur_r_id)');
        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier CHANGE log log DOUBLE PRECISION DEFAULT \'NULL\', CHANGE lat lat DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE image_id image_id INT DEFAULT NULL, CHANGE telephone telephone INT DEFAULT NULL');
    }
}
