<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420095637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe ADD create_at DATE NOT NULL, ADD update_at DATE NOT NULL, ADD delete_at DATE NOT NULL, ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE role ADD create_at DATE NOT NULL, ADD update_at DATE NOT NULL, ADD delete_at DATE NOT NULL, ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD create_at DATE NOT NULL, ADD update_at DATE NOT NULL, ADD delete_at DATE NOT NULL, ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_role ADD create_at DATE NOT NULL, ADD update_at DATE NOT NULL, ADD delete_at DATE NOT NULL, ADD is_active TINYINT(1) NOT NULL, CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe DROP create_at, DROP update_at, DROP delete_at, DROP is_active');
        $this->addSql('ALTER TABLE role DROP create_at, DROP update_at, DROP delete_at, DROP is_active');
        $this->addSql('ALTER TABLE user DROP create_at, DROP update_at, DROP delete_at, DROP is_active');
        $this->addSql('ALTER TABLE user_role DROP create_at, DROP update_at, DROP delete_at, DROP is_active, CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT \'NULL\'');
    }
}
