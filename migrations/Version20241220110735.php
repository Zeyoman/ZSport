<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241220110735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, goal VARCHAR(255) NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, INDEX IDX_D70989519D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, INDEX IDX_8933C4329D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris_video (favoris_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_AFA2A94D51E8871B (favoris_id), INDEX IDX_AFA2A94D29C1004E (video_id), PRIMARY KEY(favoris_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, level VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme_video (programme_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_4FDD87FB62BB7AEE (programme_id), INDEX IDX_4FDD87FB29C1004E (video_id), PRIMARY KEY(programme_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_history (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, INDEX IDX_54AF90D09D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_history_abonnement (subscription_history_id INT NOT NULL, abonnement_id INT NOT NULL, INDEX IDX_72DC4890DCE0C437 (subscription_history_id), INDEX IDX_72DC4890F1D74413 (abonnement_id), PRIMARY KEY(subscription_history_id, abonnement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D70989519D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4329D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE favoris_video ADD CONSTRAINT FK_AFA2A94D51E8871B FOREIGN KEY (favoris_id) REFERENCES favoris (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoris_video ADD CONSTRAINT FK_AFA2A94D29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programme_video ADD CONSTRAINT FK_4FDD87FB62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programme_video ADD CONSTRAINT FK_4FDD87FB29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D09D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE subscription_history_abonnement ADD CONSTRAINT FK_72DC4890DCE0C437 FOREIGN KEY (subscription_history_id) REFERENCES subscription_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_history_abonnement ADD CONSTRAINT FK_72DC4890F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D70989519D86650F');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4329D86650F');
        $this->addSql('ALTER TABLE favoris_video DROP FOREIGN KEY FK_AFA2A94D51E8871B');
        $this->addSql('ALTER TABLE favoris_video DROP FOREIGN KEY FK_AFA2A94D29C1004E');
        $this->addSql('ALTER TABLE programme_video DROP FOREIGN KEY FK_4FDD87FB62BB7AEE');
        $this->addSql('ALTER TABLE programme_video DROP FOREIGN KEY FK_4FDD87FB29C1004E');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D09D86650F');
        $this->addSql('ALTER TABLE subscription_history_abonnement DROP FOREIGN KEY FK_72DC4890DCE0C437');
        $this->addSql('ALTER TABLE subscription_history_abonnement DROP FOREIGN KEY FK_72DC4890F1D74413');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE favoris_video');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE programme_video');
        $this->addSql('DROP TABLE subscription_history');
        $this->addSql('DROP TABLE subscription_history_abonnement');
    }
}
