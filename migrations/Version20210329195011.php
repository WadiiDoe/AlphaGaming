<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329195011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date DATETIME NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, adresse VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, image VARCHAR(255) NOT NULL, nbre_place INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeux_front (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, release_date DATE DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, qte_jeux INT NOT NULL, description LONGTEXT DEFAULT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, iduser VARCHAR(255) NOT NULL, idevent VARCHAR(255) NOT NULL, nbrplace INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serveur_front (id INT AUTO_INCREMENT NOT NULL, jeux_id INT DEFAULT NULL, adr_sv VARCHAR(255) NOT NULL, description_sv LONGTEXT DEFAULT NULL, nom_sv VARCHAR(255) NOT NULL, INDEX IDX_77CC53A6EC2AA9D2 (jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, email VARCHAR(30) NOT NULL, adresse VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, dn DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE serveur_front ADD CONSTRAINT FK_77CC53A6EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux_front (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serveur_front DROP FOREIGN KEY FK_77CC53A6EC2AA9D2');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE jeux_front');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE serveur_front');
        $this->addSql('DROP TABLE utilisateur');
    }
}
