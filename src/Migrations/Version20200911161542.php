<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200911161542 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, part_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_F981B52E4CE34BEC (part_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, formator_id INT NOT NULL, sub_category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, level VARCHAR(15) NOT NULL, language VARCHAR(4) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, online TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_169E6FB99897707C (formator_id), INDEX IDX_169E6FB9F7BFE87C (sub_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_490F70C6591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prerequisite (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_4594A238591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, location_id INT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, gender VARCHAR(1) DEFAULT NULL, job VARCHAR(40) DEFAULT NULL, share_profile TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id), INDEX IDX_8157AA0F64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, registration_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE world_countries (id INT AUTO_INCREMENT NOT NULL, alpha3 VARCHAR(3) NOT NULL, name_fr VARCHAR(45) NOT NULL, name_en VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E4CE34BEC FOREIGN KEY (part_id) REFERENCES part (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB99897707C FOREIGN KEY (formator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE part ADD CONSTRAINT FK_490F70C6591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE prerequisite ADD CONSTRAINT FK_4594A238591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F64D218E FOREIGN KEY (location_id) REFERENCES world_countries (id)');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('ALTER TABLE part DROP FOREIGN KEY FK_490F70C6591CC992');
        $this->addSql('ALTER TABLE prerequisite DROP FOREIGN KEY FK_4594A238591CC992');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E4CE34BEC');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9F7BFE87C');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB99897707C');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F64D218E');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE part');
        $this->addSql('DROP TABLE prerequisite');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE world_countries');
    }
}
