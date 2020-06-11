<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527095105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP id_category');
        $this->addSql('ALTER TABLE groupe CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE product DROP id_supplier, DROP id_category, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE role CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_role CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category ADD id_category VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE groupe CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product ADD id_supplier VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD id_category VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE role CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user_role CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT \'NULL\'');
    }
}
