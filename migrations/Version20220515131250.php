<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515131250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_case ADD report_id INT NOT NULL');
        $this->addSql('ALTER TABLE test_case ADD CONSTRAINT FK_7D71B3CB4BD2A4C0 FOREIGN KEY (report_id) REFERENCES test_report (id)');
        $this->addSql('CREATE INDEX IDX_7D71B3CB4BD2A4C0 ON test_case (report_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test_case DROP FOREIGN KEY FK_7D71B3CB4BD2A4C0');
        $this->addSql('DROP INDEX IDX_7D71B3CB4BD2A4C0 ON test_case');
        $this->addSql('ALTER TABLE test_case DROP report_id');
    }
}
