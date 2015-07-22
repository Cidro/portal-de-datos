<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140226114532 extends AbstractMigration {
    protected $recursos = array();
    protected $config = array();

    public function up(Schema $schema) {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("
            CREATE TABLE vista_junar (
                id INT AUTO_INCREMENT NOT NULL,
                recurso_id INT DEFAULT NULL,
                junar_guid VARCHAR(255) NOT NULL,
                title VARCHAR(255) NOT NULL,
                description LONGTEXT NOT NULL,
                tags VARCHAR(255) NOT NULL,
                source VARCHAR(255) NOT NULL,
                category VARCHAR(255) NOT NULL,
                meta_data VARCHAR(255) NOT NULL,
                table_id INT NOT NULL,
                type ENUM('conjuntos', 'vistas', 'visualizaciones', 'colecciones') NOT NULL DEFAULT 'vistas',
                published TINYINT(1) NULL DEFAULT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                INDEX IDX_6E080871E52B6C4E (recurso_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("ALTER TABLE vista_junar ADD CONSTRAINT FK_6E080871E52B6C4E FOREIGN KEY (recurso_id) REFERENCES recurso (id) ON DELETE CASCADE");
    }


    public function down(Schema $schema) {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("DROP TABLE vista_junar");
    }
}
