<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117211811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_3CBF69DD462CE4F5 ON instrument');
        $this->addSql('DROP INDEX UNIQ_2D737AEF462CE4F5 ON section');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3CBF69DD462CE4F5 ON instrument (position)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D737AEF462CE4F5 ON section (position)');
    }
}
