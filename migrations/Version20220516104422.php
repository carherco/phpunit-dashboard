<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516104422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test_case (id INT AUTO_INCREMENT NOT NULL, test_suite_id INT NOT NULL, report_id INT NOT NULL, name VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, classname VARCHAR(255) NOT NULL, file LONGTEXT NOT NULL, line INT NOT NULL, assertions INT NOT NULL, time DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, failure_type VARCHAR(255) DEFAULT NULL, INDEX IDX_7D71B3CBDA9FBE4E (test_suite_id), INDEX IDX_7D71B3CB4BD2A4C0 (report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_report (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(255) NOT NULL, tests INT NOT NULL, assertions INT NOT NULL, errors INT NOT NULL, warnings INT NOT NULL, failures INT NOT NULL, skipped INT NOT NULL, time DOUBLE PRECISION NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_suite (id INT AUTO_INCREMENT NOT NULL, parent_suite_id INT DEFAULT NULL, test_report_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, tests INT NOT NULL, assertions INT NOT NULL, errors INT NOT NULL, warnings INT NOT NULL, failures INT NOT NULL, skipped INT NOT NULL, time DOUBLE PRECISION NOT NULL, INDEX IDX_1EE2422DD03119C9 (parent_suite_id), INDEX IDX_1EE2422DC94F330A (test_report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test_case ADD CONSTRAINT FK_7D71B3CBDA9FBE4E FOREIGN KEY (test_suite_id) REFERENCES test_suite (id)');
        $this->addSql('ALTER TABLE test_case ADD CONSTRAINT FK_7D71B3CB4BD2A4C0 FOREIGN KEY (report_id) REFERENCES test_report (id)');
        $this->addSql('ALTER TABLE test_suite ADD CONSTRAINT FK_1EE2422DD03119C9 FOREIGN KEY (parent_suite_id) REFERENCES test_suite (id)');
        $this->addSql('ALTER TABLE test_suite ADD CONSTRAINT FK_1EE2422DC94F330A FOREIGN KEY (test_report_id) REFERENCES test_report (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_case DROP FOREIGN KEY FK_7D71B3CB4BD2A4C0');
        $this->addSql('ALTER TABLE test_suite DROP FOREIGN KEY FK_1EE2422DC94F330A');
        $this->addSql('ALTER TABLE test_case DROP FOREIGN KEY FK_7D71B3CBDA9FBE4E');
        $this->addSql('ALTER TABLE test_suite DROP FOREIGN KEY FK_1EE2422DD03119C9');
        $this->addSql('DROP TABLE test_case');
        $this->addSql('DROP TABLE test_report');
        $this->addSql('DROP TABLE test_suite');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
