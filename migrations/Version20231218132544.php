<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218132544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, inscription_id INT DEFAULT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, intervenants LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_E1BB18235DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, lyceen_id INT NOT NULL, date_inscription DATETIME NOT NULL, UNIQUE INDEX UNIQ_5E90F6D61E0D401B (lyceen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lycee (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lyceen (id INT AUTO_INCREMENT NOT NULL, lycee_id INT NOT NULL, niveau_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EF396EA7E7927C74 (email), UNIQUE INDEX UNIQ_EF396EA7F037AB0F (tel), INDEX IDX_EF396EA7D1DC61BF (lycee_id), INDEX IDX_EF396EA7B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier (id INT AUTO_INCREMENT NOT NULL, atelier_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_51A00D8C82E2CF35 (atelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, atelier_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, capacite INT NOT NULL, UNIQUE INDEX UNIQ_4E977E5C82E2CF35 (atelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, forum_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, descritpion LONGTEXT DEFAULT NULL, INDEX IDX_8045251F29CCBAD0 (forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB18235DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D61E0D401B FOREIGN KEY (lyceen_id) REFERENCES lyceen (id)');
        $this->addSql('ALTER TABLE lyceen ADD CONSTRAINT FK_EF396EA7D1DC61BF FOREIGN KEY (lycee_id) REFERENCES lycee (id)');
        $this->addSql('ALTER TABLE lyceen ADD CONSTRAINT FK_EF396EA7B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE metier ADD CONSTRAINT FK_51A00D8C82E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5C82E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE secteur ADD CONSTRAINT FK_8045251F29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB18235DAC5993');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D61E0D401B');
        $this->addSql('ALTER TABLE lyceen DROP FOREIGN KEY FK_EF396EA7D1DC61BF');
        $this->addSql('ALTER TABLE lyceen DROP FOREIGN KEY FK_EF396EA7B3E9C81');
        $this->addSql('ALTER TABLE metier DROP FOREIGN KEY FK_51A00D8C82E2CF35');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5C82E2CF35');
        $this->addSql('ALTER TABLE secteur DROP FOREIGN KEY FK_8045251F29CCBAD0');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE lycee');
        $this->addSql('DROP TABLE lyceen');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
