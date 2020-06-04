<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200604063535 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE round (id INT AUTO_INCREMENT NOT NULL, numbers JSON NOT NULL, is_finished TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rounds_and_players (id INT AUTO_INCREMENT NOT NULL, round_id INT DEFAULT NULL, player_id INT DEFAULT NULL, number_of_rolls INT NOT NULL, INDEX IDX_A0CD62E0A6005CA0 (round_id), INDEX IDX_A0CD62E099E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rounds_and_players ADD CONSTRAINT FK_A0CD62E0A6005CA0 FOREIGN KEY (round_id) REFERENCES round (id)');
        $this->addSql('ALTER TABLE rounds_and_players ADD CONSTRAINT FK_A0CD62E099E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rounds_and_players DROP FOREIGN KEY FK_A0CD62E0A6005CA0');
        $this->addSql('ALTER TABLE rounds_and_players DROP FOREIGN KEY FK_A0CD62E099E6F5DF');
        $this->addSql('DROP TABLE round');
        $this->addSql('DROP TABLE rounds_and_players');
        $this->addSql('DROP TABLE player');
    }
}
