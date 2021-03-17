<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315135634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, wallet_id INT NOT NULL, transacted_by_id INT DEFAULT NULL, motivation VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, type SMALLINT NOT NULL, INDEX IDX_723705D1712520F3 (wallet_id), INDEX IDX_723705D18F0FFB03 (transacted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, settled TINYINT(1) NOT NULL, INDEX IDX_7C68921F7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet_user (wallet_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E001234C712520F3 (wallet_id), INDEX IDX_E001234CA76ED395 (user_id), PRIMARY KEY(wallet_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D18F0FFB03 FOREIGN KEY (transacted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wallet_user ADD CONSTRAINT FK_E001234C712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallet_user ADD CONSTRAINT FK_E001234CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1712520F3');
        $this->addSql('ALTER TABLE wallet_user DROP FOREIGN KEY FK_E001234C712520F3');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE wallet_user');
    }
}
