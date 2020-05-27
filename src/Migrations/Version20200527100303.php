<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527100303 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category ADD create_at DATE NOT NULL, ADD update_at DATE DEFAULT NULL, ADD delete_at DATE DEFAULT NULL, ADD is_active TINYINT(1) NOT NULL, CHANGE id_category id_category INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD create_at DATE NOT NULL, ADD update_at DATE DEFAULT NULL, ADD delete_at DATE DEFAULT NULL, ADD is_active TINYINT(1) NOT NULL, CHANGE id_supplier id_supplier INT DEFAULT NULL, CHANGE id_category id_category INT DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE role CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier ADD create_at DATE NOT NULL, ADD update_at DATE DEFAULT NULL, ADD delete_at DATE DEFAULT NULL, ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_role CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP create_at, DROP update_at, DROP delete_at, DROP is_active, CHANGE id_category id_category INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product DROP create_at, DROP update_at, DROP delete_at, DROP is_active, CHANGE id_supplier id_supplier INT DEFAULT NULL, CHANGE id_category id_category INT DEFAULT NULL, CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE role CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE supplier DROP create_at, DROP update_at, DROP delete_at, DROP is_active');
        $this->addSql('ALTER TABLE user CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user_role CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT \'NULL\'');
    }
}
