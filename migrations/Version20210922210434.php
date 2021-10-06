<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922210434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lcommande ADD produit_id INT DEFAULT NULL, ADD numc VARCHAR(50) NOT NULL, ADD pv VARCHAR(50) NOT NULL, ADD qte VARCHAR(50) NOT NULL, ADD tva VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE lcommande ADD CONSTRAINT FK_57961F0AF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_57961F0AF347EFB ON lcommande (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lcommande DROP FOREIGN KEY FK_57961F0AF347EFB');
        $this->addSql('DROP INDEX IDX_57961F0AF347EFB ON lcommande');
        $this->addSql('ALTER TABLE lcommande DROP produit_id, DROP numc, DROP pv, DROP qte, DROP tva');
    }
}
