<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200805101057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checkbox (id INT AUTO_INCREMENT NOT NULL, task LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, category VARCHAR(255) NOT NULL, framework VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, current_framework VARCHAR(255) NOT NULL, current_php_version VARCHAR(255) NOT NULL, desired_framework VARCHAR(255) NOT NULL, desired_php_version VARCHAR(255) NOT NULL, date_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_checkbox (id INT AUTO_INCREMENT NOT NULL, project_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', is_complete DATETIME DEFAULT NULL, INDEX IDX_23358336166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_checkbox_checkbox (project_checkbox_id INT NOT NULL, checkbox_id INT NOT NULL, INDEX IDX_CB478B81BA539A (project_checkbox_id), INDEX IDX_CB478B81C875A461 (checkbox_id), PRIMARY KEY(project_checkbox_id, checkbox_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_checkbox ADD CONSTRAINT FK_23358336166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_checkbox_checkbox ADD CONSTRAINT FK_CB478B81BA539A FOREIGN KEY (project_checkbox_id) REFERENCES project_checkbox (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_checkbox_checkbox ADD CONSTRAINT FK_CB478B81C875A461 FOREIGN KEY (checkbox_id) REFERENCES checkbox (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_checkbox_checkbox DROP FOREIGN KEY FK_CB478B81C875A461');
        $this->addSql('ALTER TABLE project_checkbox DROP FOREIGN KEY FK_23358336166D1F9C');
        $this->addSql('ALTER TABLE project_checkbox_checkbox DROP FOREIGN KEY FK_CB478B81BA539A');
        $this->addSql('DROP TABLE checkbox');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_checkbox');
        $this->addSql('DROP TABLE project_checkbox_checkbox');
    }
}
