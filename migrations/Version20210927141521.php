<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210927141521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD prenom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE commande ADD fournisseur_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D670C757F ON commande (fournisseur_id)');
        $this->addSql('ALTER TABLE fournisseur ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, DROP nom_fournisseur, DROP adresse_fournisseur');
        $this->addSql('ALTER TABLE lcommande ADD commande_id INT NOT NULL, DROP pv, DROP qte, DROP tva');
        $this->addSql('ALTER TABLE lcommande ADD CONSTRAINT FK_57961F0A82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_57961F0A82EA2E54 ON lcommande (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP prenom');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D670C757F');
        $this->addSql('DROP INDEX IDX_6EEAA67D670C757F ON commande');
        $this->addSql('ALTER TABLE commande DROP fournisseur_id');
        $this->addSql('ALTER TABLE fournisseur ADD nom_fournisseur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD adresse_fournisseur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP nom, DROP prenom, DROP adresse');
        $this->addSql('ALTER TABLE lcommande DROP FOREIGN KEY FK_57961F0A82EA2E54');
        $this->addSql('DROP INDEX IDX_57961F0A82EA2E54 ON lcommande');
        $this->addSql('ALTER TABLE lcommande ADD pv VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD qte VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD tva VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP commande_id');
    }
}
