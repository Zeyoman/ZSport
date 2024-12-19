<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241219162217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE rapport ADD user_id INT DEFAULT NULL, ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_BE34A09CA76ED395 ON rapport (user_id)');
        $this->addSql('CREATE INDEX IDX_BE34A09C29C1004E ON rapport (video_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CA76ED395');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C29C1004E');
        $this->addSql('DROP INDEX IDX_BE34A09CA76ED395 ON rapport');
        $this->addSql('DROP INDEX IDX_BE34A09C29C1004E ON rapport');
        $this->addSql('ALTER TABLE rapport DROP user_id, DROP video_id');
    }
}
