<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241219152950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE commentaire ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC29C1004E ON commentaire (video_id)');
        $this->addSql('ALTER TABLE note ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1429C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA1429C1004E ON note (video_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC29C1004E');
        $this->addSql('DROP INDEX IDX_67F068BC29C1004E ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP video_id');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1429C1004E');
        $this->addSql('DROP INDEX IDX_CFBDFA1429C1004E ON note');
        $this->addSql('ALTER TABLE note DROP video_id');
    }
}
