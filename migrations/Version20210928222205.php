<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210928222205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD nom INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276C6E55B5 FOREIGN KEY (nom) REFERENCES fournisseur (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC276C6E55B5 ON produit (nom)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276C6E55B5');
        $this->addSql('DROP INDEX IDX_29A5EC276C6E55B5 ON produit');
        $this->addSql('ALTER TABLE produit DROP nom');
    }
}
