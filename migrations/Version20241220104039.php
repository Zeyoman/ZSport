<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241220104039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE abonnement ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE note ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE video ADD level VARCHAR(255) NOT NULL, ADD view INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE abonnement DROP description');
        $this->addSql('ALTER TABLE note DROP date');
        $this->addSql('ALTER TABLE video DROP level, DROP view');
    }
}
