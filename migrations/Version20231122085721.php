<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122085721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competition ADD sport_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB164F9C039 FOREIGN KEY (sport_type_id) REFERENCES sport_type (id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB164F9C039 ON competition (sport_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB164F9C039');
        $this->addSql('DROP INDEX IDX_B50A2CB164F9C039 ON competition');
        $this->addSql('ALTER TABLE competition DROP sport_type_id');
    }
}
