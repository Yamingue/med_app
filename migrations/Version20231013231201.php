<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013231201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre_viteaux ADD consultation_id INT NOT NULL');
        $this->addSql('ALTER TABLE parametre_viteaux ADD CONSTRAINT FK_BF8BF9C062FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BF8BF9C062FF6CDF ON parametre_viteaux (consultation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre_viteaux DROP FOREIGN KEY FK_BF8BF9C062FF6CDF');
        $this->addSql('DROP INDEX UNIQ_BF8BF9C062FF6CDF ON parametre_viteaux');
        $this->addSql('ALTER TABLE parametre_viteaux DROP consultation_id');
    }
}
