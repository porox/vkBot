<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180320210556 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE post (hash VARCHAR(32) NOT NULL, tag_id VARCHAR(255) DEFAULT NULL, post_data CLOB NOT NULL --(DC2Type:json)
        , published BOOLEAN DEFAULT NULL, PRIMARY KEY(hash))');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DBAD26311 ON post (tag_id)');
        $this->addSql('CREATE TABLE tags (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user (id INTEGER NOT NULL, token VARCHAR(255) NOT NULL, vk_user_id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_groups (id INTEGER NOT NULL, user_id_id INTEGER DEFAULT NULL, tag_id VARCHAR(255) DEFAULT NULL, group_id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_953F224D9D86650F ON user_groups (user_id_id)');
        $this->addSql('CREATE INDEX IDX_953F224DBAD26311 ON user_groups (tag_id)');
        $this->addSql('CREATE TABLE watching_groups (id INTEGER NOT NULL, tag_id VARCHAR(255) DEFAULT NULL, short_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6385BA3ABAD26311 ON watching_groups (tag_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_groups');
        $this->addSql('DROP TABLE watching_groups');
    }
}
