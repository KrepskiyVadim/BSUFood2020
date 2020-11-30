<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201129214553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dishes history');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE user ADD phonenumber VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649EFF286D2 ON user (phonenumber)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dishes history (ID_Order INT NOT NULL, Date DATE NOT NULL, ID_User INT NOT NULL, Sum NUMERIC(10, 0) NOT NULL, UNIQUE INDEX ID_User (ID_User), PRIMARY KEY(ID_Order)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `order` (ID_Order INT NOT NULL, ID_Dishes INT NOT NULL, Number INT NOT NULL, Sum NUMERIC(10, 0) NOT NULL, PRIMARY KEY(ID_Dishes)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649EFF286D2 ON user');
        $this->addSql('ALTER TABLE user DROP phonenumber, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
