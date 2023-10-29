<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231029141927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resultat_exam ADD examen_id INT NOT NULL');
        $this->addSql('ALTER TABLE resultat_exam ADD CONSTRAINT FK_9E0E2AE75C8659A FOREIGN KEY (examen_id) REFERENCES exament (id)');
        $this->addSql('CREATE INDEX IDX_9E0E2AE75C8659A ON resultat_exam (examen_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resultat_exam DROP FOREIGN KEY FK_9E0E2AE75C8659A');
        $this->addSql('DROP INDEX IDX_9E0E2AE75C8659A ON resultat_exam');
        $this->addSql('ALTER TABLE resultat_exam DROP examen_id');
    }
}
