<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218133223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier ADD secteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB18239F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('CREATE INDEX IDX_E1BB18239F7E4405 ON atelier (secteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB18239F7E4405');
        $this->addSql('DROP INDEX IDX_E1BB18239F7E4405 ON atelier');
        $this->addSql('ALTER TABLE atelier DROP secteur_id');
    }
}
