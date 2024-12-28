<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241228095257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE challenge ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D7098951A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D7098951A76ED395 ON challenge (user_id)');
        $this->addSql('ALTER TABLE favoris ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8933C432A76ED395 ON favoris (user_id)');
        $this->addSql('ALTER TABLE subscription_history ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_54AF90D0A76ED395 ON subscription_history (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D7098951A76ED395');
        $this->addSql('DROP INDEX IDX_D7098951A76ED395 ON challenge');
        $this->addSql('ALTER TABLE challenge DROP user_id');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432A76ED395');
        $this->addSql('DROP INDEX IDX_8933C432A76ED395 ON favoris');
        $this->addSql('ALTER TABLE favoris DROP user_id');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D0A76ED395');
        $this->addSql('DROP INDEX IDX_54AF90D0A76ED395 ON subscription_history');
        $this->addSql('ALTER TABLE subscription_history DROP user_id');
    }
}
