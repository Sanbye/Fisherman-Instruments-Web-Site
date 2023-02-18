<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116020109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE precommande DROP FOREIGN KEY FK_7A250B455D8BC1F8');
        $this->addSql('ALTER TABLE precommande_instrument DROP FOREIGN KEY FK_F5FD9D4BCF11D9C');
        $this->addSql('ALTER TABLE precommande_instrument DROP FOREIGN KEY FK_F5FD9D4BB8E087ED');
        $this->addSql('ALTER TABLE precommande_prestation DROP FOREIGN KEY FK_988A7B3B9E45C554');
        $this->addSql('ALTER TABLE precommande_prestation DROP FOREIGN KEY FK_988A7B3BB8E087ED');
        $this->addSql('DROP TABLE precommande');
        $this->addSql('DROP TABLE precommande_instrument');
        $this->addSql('DROP TABLE precommande_prestation');
        $this->addSql('ALTER TABLE info ADD text LONGTEXT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3CBF69DD462CE4F5 ON instrument (position)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51C88FAD462CE4F5 ON prestation (position)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D737AEF462CE4F5 ON section (position)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE precommande (id INT AUTO_INCREMENT NOT NULL, info_id INT NOT NULL, renseignements LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, somme INT NOT NULL, paiement TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_7A250B455D8BC1F8 (info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE precommande_instrument (precommande_id INT NOT NULL, instrument_id INT NOT NULL, INDEX IDX_F5FD9D4BB8E087ED (precommande_id), INDEX IDX_F5FD9D4BCF11D9C (instrument_id), PRIMARY KEY(precommande_id, instrument_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE precommande_prestation (precommande_id INT NOT NULL, prestation_id INT NOT NULL, INDEX IDX_988A7B3BB8E087ED (precommande_id), INDEX IDX_988A7B3B9E45C554 (prestation_id), PRIMARY KEY(precommande_id, prestation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE precommande ADD CONSTRAINT FK_7A250B455D8BC1F8 FOREIGN KEY (info_id) REFERENCES info (id)');
        $this->addSql('ALTER TABLE precommande_instrument ADD CONSTRAINT FK_F5FD9D4BCF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE precommande_instrument ADD CONSTRAINT FK_F5FD9D4BB8E087ED FOREIGN KEY (precommande_id) REFERENCES precommande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE precommande_prestation ADD CONSTRAINT FK_988A7B3B9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE precommande_prestation ADD CONSTRAINT FK_988A7B3BB8E087ED FOREIGN KEY (precommande_id) REFERENCES precommande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info DROP text');
        $this->addSql('DROP INDEX UNIQ_3CBF69DD462CE4F5 ON instrument');
        $this->addSql('DROP INDEX UNIQ_51C88FAD462CE4F5 ON prestation');
        $this->addSql('DROP INDEX UNIQ_2D737AEF462CE4F5 ON section');
    }
}
