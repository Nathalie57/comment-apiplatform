<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117140105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD comment_parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9B042B26 FOREIGN KEY (comment_parent_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_9474526C9B042B26 ON comment (comment_parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9B042B26');
        $this->addSql('DROP INDEX IDX_9474526C9B042B26 ON comment');
        $this->addSql('ALTER TABLE comment DROP comment_parent_id');
    }
}
