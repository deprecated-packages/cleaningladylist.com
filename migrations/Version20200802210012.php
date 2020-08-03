<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200802210012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checkbox (id INT AUTO_INCREMENT NOT NULL, task LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, category VARCHAR(255) NOT NULL, framework VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE checklist (id INT AUTO_INCREMENT NOT NULL, project_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', checkbox_id INT DEFAULT NULL, INDEX IDX_5C696D2F166D1F9C (project_id), INDEX IDX_5C696D2FC875A461 (checkbox_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, current_framework VARCHAR(255) NOT NULL, current_php_version VARCHAR(255) NOT NULL, desired_framework VARCHAR(255) NOT NULL, desired_php_version VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE checklist ADD CONSTRAINT FK_5C696D2FC875A461 FOREIGN KEY (checkbox_id) REFERENCES checkbox (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE checklist DROP FOREIGN KEY FK_5C696D2FC875A461');
        $this->addSql('ALTER TABLE checklist DROP FOREIGN KEY FK_5C696D2F166D1F9C');
        $this->addSql('DROP TABLE checkbox');
        $this->addSql('DROP TABLE checklist');
        $this->addSql('DROP TABLE project');
    }
}
