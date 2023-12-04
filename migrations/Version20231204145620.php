<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204145620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calorique (id INT AUTO_INCREMENT NOT NULL, imcs_id INT DEFAULT NULL, objectif VARCHAR(255) DEFAULT NULL, besoins_caloriques DOUBLE PRECISION DEFAULT NULL, activite VARCHAR(255) DEFAULT NULL, regime_alimentaire VARCHAR(255) NOT NULL, niveau_stress VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D58D83D1930D401 (imcs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imc (id INT AUTO_INCREMENT NOT NULL, sexe VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, taille DOUBLE PRECISION DEFAULT NULL, poids DOUBLE PRECISION DEFAULT NULL, categorie_imc VARCHAR(255) DEFAULT NULL, poids_ideal DOUBLE PRECISION DEFAULT NULL, imc DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calorique ADD CONSTRAINT FK_D58D83D1930D401 FOREIGN KEY (imcs_id) REFERENCES imc (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calorique DROP FOREIGN KEY FK_D58D83D1930D401');
        $this->addSql('DROP TABLE calorique');
        $this->addSql('DROP TABLE imc');
    }
}
