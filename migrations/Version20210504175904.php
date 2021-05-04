<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504175904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aliment (id INT AUTO_INCREMENT NOT NULL, sous_groupe_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, INDEX IDX_70FF972B614CDEC3 (sous_groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aliment_repas (aliment_id INT NOT NULL, repas_id INT NOT NULL, INDEX IDX_A652DD7B415B9F11 (aliment_id), INDEX IDX_A652DD7B1D236AAA (repas_id), PRIMARY KEY(aliment_id, repas_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repas (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, INDEX IDX_D4A67ED67A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT FK_70FF972B614CDEC3 FOREIGN KEY (sous_groupe_id) REFERENCES sous_groupe (id)');
        $this->addSql('ALTER TABLE aliment_repas ADD CONSTRAINT FK_A652DD7B415B9F11 FOREIGN KEY (aliment_id) REFERENCES aliment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE aliment_repas ADD CONSTRAINT FK_A652DD7B1D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sous_groupe ADD CONSTRAINT FK_D4A67ED67A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aliment_repas DROP FOREIGN KEY FK_A652DD7B415B9F11');
        $this->addSql('ALTER TABLE sous_groupe DROP FOREIGN KEY FK_D4A67ED67A45358C');
        $this->addSql('ALTER TABLE aliment_repas DROP FOREIGN KEY FK_A652DD7B1D236AAA');
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY FK_70FF972B614CDEC3');
        $this->addSql('DROP TABLE aliment');
        $this->addSql('DROP TABLE aliment_repas');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE repas');
        $this->addSql('DROP TABLE sous_groupe');
    }
}
