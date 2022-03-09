<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308110606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipe CHANGE nom nom VARCHAR(55) DEFAULT NULL, CHANGE prenom prenom VARCHAR(55) DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE metier metier VARCHAR(55) DEFAULT NULL');
        $this->addSql('ALTER TABLE equippement CHANGE nom nom VARCHAR(44) DEFAULT NULL, CHANGE metier metier VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE offre CHANGE nom nom VARCHAR(55) DEFAULT NULL, CHANGE prenom prenom VARCHAR(55) DEFAULT NULL, CHANGE num num VARCHAR(55) DEFAULT NULL, CHANGE text text VARCHAR(65) DEFAULT NULL');
        $this->addSql('ALTER TABLE pack CHANGE nom nom VARCHAR(55) DEFAULT NULL, CHANGE prenom prenom VARCHAR(55) DEFAULT NULL, CHANGE numcommande numcommande VARCHAR(55) DEFAULT NULL, CHANGE text text VARCHAR(65) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD discount DOUBLE PRECISION DEFAULT NULL, ADD initial_price DOUBLE PRECISION DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE quantite quantite INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipe CHANGE nom nom VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE age age INT DEFAULT NULL, CHANGE metier metier VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE equippement CHANGE nom nom VARCHAR(44) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE metier metier VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE offre CHANGE nom nom VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE num num VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE text text VARCHAR(65) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pack CHANGE nom nom VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE numcommande numcommande VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE text text VARCHAR(65) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product DROP discount, DROP initial_price, CHANGE category_id category_id INT DEFAULT NULL, CHANGE quantite quantite INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}