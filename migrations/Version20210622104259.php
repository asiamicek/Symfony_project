<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622104259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9AB945D82');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE usersdata');
        $this->addSql('ALTER TABLE registers CHANGE author_id author_id INT UNSIGNED NOT NULL');
        $this->addSql('DROP INDEX UNIQ_1483A5E9AB945D82 ON users');
        $this->addSql('ALTER TABLE users ADD firstname VARCHAR(64) NOT NULL, ADD lastname VARCHAR(128) NOT NULL, DROP userdata_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, task_status VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE usersdata (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lastname VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE registers CHANGE author_id author_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD userdata_id INT DEFAULT NULL, DROP firstname, DROP lastname');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9AB945D82 FOREIGN KEY (userdata_id) REFERENCES usersdata (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9AB945D82 ON users (userdata_id)');
    }
}
