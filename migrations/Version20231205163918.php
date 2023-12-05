<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205163918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, duree INT NOT NULL, notes VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercices (id INT AUTO_INCREMENT NOT NULL, nom_e VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, duree_e INT NOT NULL, repetitions INT NOT NULL, series INT NOT NULL, objectif VARCHAR(255) NOT NULL, niveau_difficulte VARCHAR(255) NOT NULL, progress INT NOT NULL, image_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, due_date DATE NOT NULL, completed TINYINT(1) NOT NULL, priority INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE exercices');
        $this->addSql('DROP TABLE task');
    }
}
