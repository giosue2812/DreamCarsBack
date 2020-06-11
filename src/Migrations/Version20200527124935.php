<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527124935 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE id_category id_category INT DEFAULT NULL, CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD id_subCategory INT DEFAULT NULL, CHANGE id_supplier id_supplier INT DEFAULT NULL, CHANGE id_category id_category INT DEFAULT NULL, CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADECB80BE9 FOREIGN KEY (id_subCategory) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADECB80BE9 ON product (id_subCategory)');
        $this->addSql('ALTER TABLE role CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE update_at update_at DATE DEFAULT NULL, CHANGE delete_at delete_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_role CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE id_category id_category INT DEFAULT NULL, CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE groupe CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADECB80BE9');
        $this->addSql('DROP INDEX IDX_D34A04ADECB80BE9 ON product');
        $this->addSql('ALTER TABLE product DROP id_subCategory, CHANGE id_supplier id_supplier INT DEFAULT NULL, CHANGE id_category id_category INT DEFAULT NULL, CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\', CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE role CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE supplier CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE update_at update_at DATE DEFAULT \'NULL\', CHANGE delete_at delete_at DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user_role CHANGE users_id users_id INT DEFAULT NULL, CHANGE roles_id roles_id INT DEFAULT NULL, CHANGE end_date end_date DATETIME DEFAULT \'NULL\'');
    }
}
