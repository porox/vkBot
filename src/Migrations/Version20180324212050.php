<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180324212050 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_5A8A6C8DBAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT hash, tag_id, post_data, published FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (hash VARCHAR(32) NOT NULL COLLATE BINARY, tag_id INTEGER DEFAULT NULL, post_data CLOB NOT NULL, published BOOLEAN DEFAULT \'0\' NOT NULL, PRIMARY KEY(hash), CONSTRAINT FK_5A8A6C8DBAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (hash, tag_id, post_data, published) SELECT hash, tag_id, post_data, published FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DBAD26311 ON post (tag_id)');
        $this->addSql('DROP INDEX IDX_953F224D9D86650F');
        $this->addSql('DROP INDEX IDX_953F224DBAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_groups AS SELECT id, user_id_id, tag_id, group_id FROM user_groups');
        $this->addSql('DROP TABLE user_groups');
        $this->addSql('CREATE TABLE user_groups (id INTEGER NOT NULL, user_id_id INTEGER DEFAULT NULL, tag_id INTEGER DEFAULT NULL, group_id INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_953F224D9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_953F224DBAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_groups (id, user_id_id, tag_id, group_id) SELECT id, user_id_id, tag_id, group_id FROM __temp__user_groups');
        $this->addSql('DROP TABLE __temp__user_groups');
        $this->addSql('CREATE INDEX IDX_953F224D9D86650F ON user_groups (user_id_id)');
        $this->addSql('CREATE INDEX IDX_953F224DBAD26311 ON user_groups (tag_id)');
        $this->addSql('DROP INDEX IDX_6385BA3A9D86650F');
        $this->addSql('DROP INDEX IDX_6385BA3ABAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__watching_groups AS SELECT id, tag_id, user_id_id, short_name FROM watching_groups');
        $this->addSql('DROP TABLE watching_groups');
        $this->addSql('CREATE TABLE watching_groups (id INTEGER NOT NULL, tag_id INTEGER DEFAULT NULL, user_id_id INTEGER DEFAULT NULL, short_name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_6385BA3ABAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6385BA3A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO watching_groups (id, tag_id, user_id_id, short_name) SELECT id, tag_id, user_id_id, short_name FROM __temp__watching_groups');
        $this->addSql('DROP TABLE __temp__watching_groups');
        $this->addSql('CREATE INDEX IDX_6385BA3A9D86650F ON watching_groups (user_id_id)');
        $this->addSql('CREATE INDEX IDX_6385BA3ABAD26311 ON watching_groups (tag_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_5A8A6C8DBAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT hash, tag_id, post_data, published FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (hash VARCHAR(32) NOT NULL, tag_id INTEGER DEFAULT NULL, post_data CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , published BOOLEAN DEFAULT NULL, PRIMARY KEY(hash))');
        $this->addSql('INSERT INTO post (hash, tag_id, post_data, published) SELECT hash, tag_id, post_data, published FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DBAD26311 ON post (tag_id)');
        $this->addSql('DROP INDEX IDX_953F224D9D86650F');
        $this->addSql('DROP INDEX IDX_953F224DBAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_groups AS SELECT id, user_id_id, tag_id, group_id FROM user_groups');
        $this->addSql('DROP TABLE user_groups');
        $this->addSql('CREATE TABLE user_groups (id INTEGER NOT NULL, user_id_id INTEGER DEFAULT NULL, tag_id INTEGER DEFAULT NULL, group_id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO user_groups (id, user_id_id, tag_id, group_id) SELECT id, user_id_id, tag_id, group_id FROM __temp__user_groups');
        $this->addSql('DROP TABLE __temp__user_groups');
        $this->addSql('CREATE INDEX IDX_953F224D9D86650F ON user_groups (user_id_id)');
        $this->addSql('CREATE INDEX IDX_953F224DBAD26311 ON user_groups (tag_id)');
        $this->addSql('DROP INDEX IDX_6385BA3ABAD26311');
        $this->addSql('DROP INDEX IDX_6385BA3A9D86650F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__watching_groups AS SELECT id, tag_id, user_id_id, short_name FROM watching_groups');
        $this->addSql('DROP TABLE watching_groups');
        $this->addSql('CREATE TABLE watching_groups (id INTEGER NOT NULL, tag_id INTEGER DEFAULT NULL, user_id_id INTEGER DEFAULT NULL, short_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO watching_groups (id, tag_id, user_id_id, short_name) SELECT id, tag_id, user_id_id, short_name FROM __temp__watching_groups');
        $this->addSql('DROP TABLE __temp__watching_groups');
        $this->addSql('CREATE INDEX IDX_6385BA3ABAD26311 ON watching_groups (tag_id)');
        $this->addSql('CREATE INDEX IDX_6385BA3A9D86650F ON watching_groups (user_id_id)');
    }
}
