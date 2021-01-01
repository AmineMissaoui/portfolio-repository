<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210101105850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio_images DROP FOREIGN KEY FK_E6F4535F166D1F9C');
        $this->addSql('CREATE TABLE portfolio_project (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, link LONGTEXT NOT NULL, client VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_7906FF2012469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portfolio_project ADD CONSTRAINT FK_7906FF2012469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP INDEX IDX_E6F4535F166D1F9C ON portfolio_images');
        $this->addSql('ALTER TABLE portfolio_images CHANGE project_id portfolio_project_id INT NOT NULL');
        $this->addSql('ALTER TABLE portfolio_images ADD CONSTRAINT FK_E6F4535F244BDBEE FOREIGN KEY (portfolio_project_id) REFERENCES portfolio_project (id)');
        $this->addSql('CREATE INDEX IDX_E6F4535F244BDBEE ON portfolio_images (portfolio_project_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio_images DROP FOREIGN KEY FK_E6F4535F244BDBEE');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, link LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, client VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, creation_date DATETIME NOT NULL, INDEX IDX_2FB3D0EE12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('DROP TABLE portfolio_project');
        $this->addSql('DROP INDEX IDX_E6F4535F244BDBEE ON portfolio_images');
        $this->addSql('ALTER TABLE portfolio_images CHANGE portfolio_project_id project_id INT NOT NULL');
        $this->addSql('ALTER TABLE portfolio_images ADD CONSTRAINT FK_E6F4535F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_E6F4535F166D1F9C ON portfolio_images (project_id)');
    }
}
