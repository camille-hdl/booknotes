<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Use ULIDs as identifiers
 */
final class Version20201227224201 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Use ULIDs as identifiers';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('SET foreign_key_checks = 0');
        $this->addSql('ALTER TABLE book CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE user_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE note CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE book_id book_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', CHANGE user_id user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('SET foreign_key_checks = 1');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('SET foreign_key_checks = 0');
        $this->addSql('ALTER TABLE book CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE note CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE book_id book_id INT DEFAULT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('SET foreign_key_checks = 1');
    }
}
