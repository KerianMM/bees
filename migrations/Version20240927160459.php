<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240927160459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE game_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bee (id INT NOT NULL, game_id INT NOT NULL, hit_points INT NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9140CC69E48FD905 ON bee (game_id)');
        $this->addSql('CREATE TABLE game (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE bee ADD CONSTRAINT FK_9140CC69E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE bee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE game_id_seq CASCADE');
        $this->addSql('ALTER TABLE bee DROP CONSTRAINT FK_9140CC69E48FD905');
        $this->addSql('DROP TABLE bee');
        $this->addSql('DROP TABLE game');
    }
}
