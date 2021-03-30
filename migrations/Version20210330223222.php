<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330223222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `exposee` (id INT AUTO_INCREMENT NOT NULL, date_c DATE NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fidelite (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, points VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_EF425B23FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, exposee_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_876E0D970DF752 (exposee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(30) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, code INT NOT NULL, reset_code VARCHAR(50) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fidelite ADD CONSTRAINT FK_EF425B23FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D970DF752 FOREIGN KEY (exposee_id) REFERENCES `exposee` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D970DF752');
        $this->addSql('ALTER TABLE fidelite DROP FOREIGN KEY FK_EF425B23FB88E14F');
        $this->addSql('DROP TABLE `exposee`');
        $this->addSql('DROP TABLE fidelite');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE user');
    }
}
