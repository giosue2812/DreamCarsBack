<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527100205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category ADD id_category INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C15697F554 FOREIGN KEY (id_category) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_64C19C15697F554 ON category (id_category)');
        $this->addSql('ALTER TABLE groupe CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE id_supplier id_supplier INT DEFAULT NULL, CHANGE id_category id_category INT DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE role CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_role CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C15697F554');
        $this->addSql('DROP INDEX IDX_64C19C15697F554 ON category');
        $this->addSql('ALTER TABLE category DROP id_category');
        $this->addSql('ALTER TABLE groupe CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product CHANGE id_supplier id_supplier INT DEFAULT NULL, CHANGE id_category id_category INT DEFAULT NULL, CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE role CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user_role CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT \'NULL\'');
    }
}
