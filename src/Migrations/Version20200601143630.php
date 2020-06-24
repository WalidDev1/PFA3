<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601143630 extends AbstractMigration
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
        //$this->addSql('ALTER TABLE offre ADD quartier_id INT NOT NULL, ADD quatier_id INT NOT NULL');
        //$this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FDF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
        //$this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F624C86CD FOREIGN KEY (quatier_id) REFERENCES quartier (id)');
        //$this->addSql('CREATE INDEX IDX_AF86866FDF1E57AB ON offre (quartier_id)');
        //$this->addSql('CREATE INDEX IDX_AF86866F624C86CD ON offre (quatier_id)');
        //$this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FDF1E57AB');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F624C86CD');
        $this->addSql('DROP INDEX IDX_AF86866FDF1E57AB ON offre');
        $this->addSql('DROP INDEX IDX_AF86866F624C86CD ON offre');
        $this->addSql('ALTER TABLE offre DROP quartier_id, DROP quatier_id');
        $this->addSql('ALTER TABLE quartier CHANGE log log DOUBLE PRECISION DEFAULT \'NULL\', CHANGE lat lat DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE image_id image_id INT DEFAULT NULL, CHANGE telephone telephone INT DEFAULT NULL');
    }
}
