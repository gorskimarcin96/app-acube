<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220404123606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added convert_file table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE convert_file_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE convert_file (id INT NOT NULL, content_from TEXT NOT NULL, content_to TEXT DEFAULT NULL, type_from VARCHAR(4) CHECK(type_from IN (\'json\', \'xml\')) NOT NULL, type_to VARCHAR(4) CHECK(type_to IN (\'json\', \'xml\'))  NOT NULL, status VARCHAR(10) CHECK(status IN (\'draft\', \'pending\', \'done\'))  NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN convert_file.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN convert_file.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE convert_file_id_seq CASCADE');
        $this->addSql('DROP TABLE convert_file');
    }
}
