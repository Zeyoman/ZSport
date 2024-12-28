<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241228011649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_video (user_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_9E052174A76ED395 (user_id), INDEX IDX_9E05217429C1004E (video_id), PRIMARY KEY(user_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_video ADD CONSTRAINT FK_9E052174A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_video ADD CONSTRAINT FK_9E05217429C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D70989519D86650F');
        $this->addSql('DROP INDEX IDX_D70989519D86650F ON challenge');
        $this->addSql('ALTER TABLE challenge DROP user_id_id');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4329D86650F');
        $this->addSql('DROP INDEX IDX_8933C4329D86650F ON favoris');
        $this->addSql('ALTER TABLE favoris DROP user_id_id');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D09D86650F');
        $this->addSql('DROP INDEX IDX_54AF90D09D86650F ON subscription_history');
        $this->addSql('ALTER TABLE subscription_history DROP user_id_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_video DROP FOREIGN KEY FK_9E052174A76ED395');
        $this->addSql('ALTER TABLE user_video DROP FOREIGN KEY FK_9E05217429C1004E');
        $this->addSql('DROP TABLE user_video');
        $this->addSql('ALTER TABLE challenge ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D70989519D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D70989519D86650F ON challenge (user_id_id)');
        $this->addSql('ALTER TABLE favoris ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4329D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8933C4329D86650F ON favoris (user_id_id)');
        $this->addSql('ALTER TABLE subscription_history ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_54AF90D09D86650F ON subscription_history (user_id_id)');
    }
}
