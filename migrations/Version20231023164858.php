<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023164858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exament_exam_item (exament_id INT NOT NULL, exam_item_id INT NOT NULL, INDEX IDX_829E9AFC6A7937A3 (exament_id), INDEX IDX_829E9AFC1FC90B36 (exam_item_id), PRIMARY KEY(exament_id, exam_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exament_exam_item ADD CONSTRAINT FK_829E9AFC6A7937A3 FOREIGN KEY (exament_id) REFERENCES exament (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exament_exam_item ADD CONSTRAINT FK_829E9AFC1FC90B36 FOREIGN KEY (exam_item_id) REFERENCES exam_item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exament_exam_item DROP FOREIGN KEY FK_829E9AFC6A7937A3');
        $this->addSql('ALTER TABLE exament_exam_item DROP FOREIGN KEY FK_829E9AFC1FC90B36');
        $this->addSql('DROP TABLE exament_exam_item');
    }
}
