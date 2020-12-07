<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206141336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_list DROP FOREIGN KEY FK_939C20FFCDAEAAA');
        $this->addSql('DROP INDEX IDX_939C20FFCDAEAAA ON order_list');
        $this->addSql('ALTER TABLE order_list ADD address VARCHAR(510) NOT NULL, CHANGE order_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_list ADD CONSTRAINT FK_939C20FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_939C20FA76ED395 ON order_list (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_list DROP FOREIGN KEY FK_939C20FA76ED395');
        $this->addSql('DROP INDEX IDX_939C20FA76ED395 ON order_list');
        $this->addSql('ALTER TABLE order_list DROP address, CHANGE user_id order_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_list ADD CONSTRAINT FK_939C20FFCDAEAAA FOREIGN KEY (order_id_id) REFERENCES order_from_menu (id)');
        $this->addSql('CREATE INDEX IDX_939C20FFCDAEAAA ON order_list (order_id_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
