<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180315204113 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT group_id, post_data, hash, published, tag FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (hash VARCHAR(32) NOT NULL, group_id VARCHAR(150) NOT NULL COLLATE BINARY, post_data CLOB NOT NULL COLLATE BINARY, published BOOLEAN DEFAULT NULL, tag VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(hash))');
        $this->addSql('INSERT INTO post (group_id, post_data, hash, published, tag) SELECT group_id, post_data, hash, published, tag FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT hash, group_id, post_data, published, tag FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER NOT NULL, group_id VARCHAR(150) NOT NULL, post_data CLOB NOT NULL, published BOOLEAN DEFAULT NULL, tag VARCHAR(255) DEFAULT NULL, hash VARCHAR(32) NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO post (hash, group_id, post_data, published, tag) SELECT hash, group_id, post_data, published, tag FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }
}
