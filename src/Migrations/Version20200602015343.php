<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200602015343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vendeur_regulier (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT NOT NULL, date_mut_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_7B65AC1E858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signalement (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, INDEX IDX_F4B5511419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, image_logo_id INT DEFAULT NULL, vendeur_r_id INT NOT NULL, date_mut_at DATETIME NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19AA96C9F4396 (image_logo_id), UNIQUE INDEX UNIQ_64C19AA9DD44EDDC (vendeur_r_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signalement_vendeur (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT NOT NULL, INDEX IDX_845CD162858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vendeur_regulier ADD CONSTRAINT FK_7B65AC1E858C065E FOREIGN KEY (vendeur_id) REFERENCES vendeur (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B5511419EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA96C9F4396 FOREIGN KEY (image_logo_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9DD44EDDC FOREIGN KEY (vendeur_r_id) REFERENCES vendeur_regulier (id)');
        $this->addSql('ALTER TABLE signalement_vendeur ADD CONSTRAINT FK_845CD162858C065E FOREIGN KEY (vendeur_id) REFERENCES vendeur (id)');
        $this->addSql('ALTER TABLE quartier CHANGE log log DOUBLE PRECISION DEFAULT NULL, CHANGE lat lat DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE image_id image_id INT DEFAULT NULL, CHANGE telephone telephone INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9DD44EDDC');
        $this->addSql('DROP TABLE vendeur_regulier');
        $this->addSql('DROP TABLE signalement');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE signalement_vendeur');
        $this->addSql('ALTER TABLE images CHANGE offre_id offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier CHANGE log log DOUBLE PRECISION DEFAULT \'NULL\', CHANGE lat lat DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE image_id image_id INT DEFAULT NULL, CHANGE telephone telephone INT DEFAULT NULL');
    }
}
