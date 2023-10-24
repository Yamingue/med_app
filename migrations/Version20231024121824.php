<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024121824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ordonance_medicament (ordonance_id INT NOT NULL, medicament_id INT NOT NULL, INDEX IDX_3DE866534DBFB927 (ordonance_id), INDEX IDX_3DE86653AB0D61F7 (medicament_id), PRIMARY KEY(ordonance_id, medicament_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ordonance_medicament ADD CONSTRAINT FK_3DE866534DBFB927 FOREIGN KEY (ordonance_id) REFERENCES ordonance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ordonance_medicament ADD CONSTRAINT FK_3DE86653AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordonance_medicament DROP FOREIGN KEY FK_3DE866534DBFB927');
        $this->addSql('ALTER TABLE ordonance_medicament DROP FOREIGN KEY FK_3DE86653AB0D61F7');
        $this->addSql('DROP TABLE ordonance_medicament');
    }
}
