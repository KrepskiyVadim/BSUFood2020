<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201103625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish_composition DROP FOREIGN KEY FK_DE6E70A2933FE08C');
        $this->addSql('DROP INDEX IDX_DE6E70A2933FE08C ON dish_composition');
        $this->addSql('ALTER TABLE dish_composition CHANGE ingredient_id dish_id INT NOT NULL');
        $this->addSql('ALTER TABLE dish_composition ADD CONSTRAINT FK_DE6E70A2148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('CREATE INDEX IDX_DE6E70A2148EB0CB ON dish_composition (dish_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish_composition DROP FOREIGN KEY FK_DE6E70A2148EB0CB');
        $this->addSql('DROP INDEX IDX_DE6E70A2148EB0CB ON dish_composition');
        $this->addSql('ALTER TABLE dish_composition CHANGE dish_id ingredient_id INT NOT NULL');
        $this->addSql('ALTER TABLE dish_composition ADD CONSTRAINT FK_DE6E70A2933FE08C FOREIGN KEY (ingredient_id) REFERENCES dish (id)');
        $this->addSql('CREATE INDEX IDX_DE6E70A2933FE08C ON dish_composition (ingredient_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
