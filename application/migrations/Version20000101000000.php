<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20000101000000 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE servicio (codigo VARCHAR(255) NOT NULL, codigo_servicio_oficial VARCHAR(255) DEFAULT NULL, entidad_codigo VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, sigla VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, publicado TINYINT(1) DEFAULT NULL, oficial TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_CB86F22A2E38766A (codigo_servicio_oficial), INDEX IDX_CB86F22AA2DCD693 (entidad_codigo), PRIMARY KEY(codigo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE vista_junar (id INT AUTO_INCREMENT NOT NULL, recurso_id INT DEFAULT NULL, junar_guid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, tags VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, meta_data VARCHAR(255) NOT NULL, table_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6E080871E52B6C4E (recurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE licencia (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE reporte (id INT AUTO_INCREMENT NOT NULL, tipo_reporte_id INT DEFAULT NULL, user_id INT DEFAULT NULL, dataset_id INT DEFAULT NULL, estado VARCHAR(1) NOT NULL, origen_publico TINYINT(1) NOT NULL, comentarios LONGTEXT DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5CB121498AAA75A (tipo_reporte_id), INDEX IDX_5CB1214A76ED395 (user_id), INDEX IDX_5CB1214D47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, servicio_codigo VARCHAR(255) DEFAULT NULL, password VARCHAR(128) NOT NULL, email VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, ministerial TINYINT(1) NOT NULL, interministerial TINYINT(1) NOT NULL, reset_code VARCHAR(255) DEFAULT NULL, reset_expiration DATETIME DEFAULT NULL, api_token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1483A5E9757D38EF (servicio_codigo), UNIQUE INDEX email_index (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE user_has_rol (user_id INT NOT NULL, rol_id VARCHAR(16) NOT NULL, INDEX IDX_62987CC7A76ED395 (user_id), INDEX IDX_62987CC74BAB96C (rol_id), PRIMARY KEY(user_id, rol_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE evaluacion (id INT AUTO_INCREMENT NOT NULL, dataset_id INT DEFAULT NULL, rating INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DEEDCA53D47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE grado_reporte (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE sector (codigo VARCHAR(255) NOT NULL, sector_padre_codigo VARCHAR(255) DEFAULT NULL, tipo VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4BA3D9E875EA9B6F (sector_padre_codigo), PRIMARY KEY(codigo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE suscripcion (id INT AUTO_INCREMENT NOT NULL, participacion_id INT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE noticia (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, resumen LONGTEXT NOT NULL, contenido LONGTEXT NOT NULL, foto VARCHAR(255) NOT NULL, publicado TINYINT(1) NOT NULL, publicado_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE email_reminder (id INT AUTO_INCREMENT NOT NULL, id_participacion VARCHAR(255) NOT NULL, titulo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, institucion VARCHAR(255) NOT NULL, created_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE recurso (id INT AUTO_INCREMENT NOT NULL, dataset_id INT DEFAULT NULL, codigo INT NOT NULL, descripcion LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, mime VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B2BB3764D47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, dataset_id INT DEFAULT NULL, dataset_version_id INT DEFAULT NULL, user_id INT DEFAULT NULL, descripcion LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8F3F68C5D47C2D1B (dataset_id), INDEX IDX_8F3F68C56E470E0A (dataset_version_id), INDEX IDX_8F3F68C5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE participacion (id INT AUTO_INCREMENT NOT NULL, institucion VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, edad INT NOT NULL, region VARCHAR(255) NOT NULL, ocupacion VARCHAR(255) NOT NULL, titulo VARCHAR(255) NOT NULL, mensaje LONGTEXT NOT NULL, categoria VARCHAR(255) NOT NULL, publicado INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enlace VARCHAR(255) NOT NULL, INDEX IDX_669B8D69F751F7C3 (institucion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE participacion_has_categoria (participacion_id INT NOT NULL, categoria_id INT NOT NULL, INDEX IDX_A0048F25C8B79933 (participacion_id), INDEX IDX_A0048F253397707A (categoria_id), PRIMARY KEY(participacion_id, categoria_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE descarga (id INT AUTO_INCREMENT NOT NULL, recurso_id INT DEFAULT NULL, fecha DATE NOT NULL, count INT NOT NULL, INDEX IDX_7FCFE06EE52B6C4E (recurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE contacto (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, email LONGTEXT NOT NULL, asunto VARCHAR(255) NOT NULL, comentarios LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE vista (id INT AUTO_INCREMENT NOT NULL, dataset_id INT DEFAULT NULL, fecha DATE NOT NULL, count INT NOT NULL, INDEX IDX_D1CF61CED47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE webforms (id INT AUTO_INCREMENT NOT NULL, campo VARCHAR(255) NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE dataset (id INT AUTO_INCREMENT NOT NULL, primera_version_publicada INT DEFAULT NULL, servicio_codigo VARCHAR(8) NOT NULL, licencia_id INT NOT NULL, maestro_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, frecuencia VARCHAR(255) DEFAULT NULL, granularidad VARCHAR(255) DEFAULT NULL, cobertura_temporal VARCHAR(255) DEFAULT NULL, ndescargas INT DEFAULT NULL, rating DOUBLE PRECISION DEFAULT NULL, maestro TINYINT(1) DEFAULT NULL, publicado TINYINT(1) DEFAULT NULL, publicado_at DATETIME DEFAULT NULL, hits INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, actualizable TINYINT(1) DEFAULT NULL, integracion_junar DATETIME DEFAULT NULL, coordenadas VARCHAR(255) DEFAULT NULL, doc_id VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B7A041D0449B8D71 (primera_version_publicada), INDEX IDX_B7A041D0757D38EF (servicio_codigo), INDEX IDX_B7A041D03A0F5A23 (licencia_id), INDEX IDX_B7A041D020E41137 (maestro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE dataset_has_sector (dataset_id INT NOT NULL, sector_codigo VARCHAR(255) NOT NULL, INDEX IDX_427AE77CD47C2D1B (dataset_id), INDEX IDX_427AE77CA7EC55F7 (sector_codigo), PRIMARY KEY(dataset_id, sector_codigo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE dataset_has_tag (dataset_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_1C9BC63FD47C2D1B (dataset_id), INDEX IDX_1C9BC63FBAD26311 (tag_id), PRIMARY KEY(dataset_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE dataset_has_categoria (dataset_id INT NOT NULL, categoria_id INT NOT NULL, INDEX IDX_AC07305D47C2D1B (dataset_id), INDEX IDX_AC073053397707A (categoria_id), PRIMARY KEY(dataset_id, categoria_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE documento (id INT AUTO_INCREMENT NOT NULL, dataset_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, mime VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B6B12EC7D47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, restricted TINYINT(1) NOT NULL, content LONGTEXT NOT NULL, UNIQUE INDEX alias_index (alias), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE rol (id VARCHAR(16) NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE navs (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, position VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE aplicacion (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, acceso VARCHAR(255) NOT NULL, plataforma VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, autor VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, publicado TINYINT(1) NOT NULL, publicado_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE entidad (codigo VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, sigla VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(codigo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE tipo_reporte (id INT AUTO_INCREMENT NOT NULL, grado_reporte_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, comentario_sugerido LONGTEXT NOT NULL, publico TINYINT(1) NOT NULL, campo_dataset VARCHAR(255) DEFAULT NULL, INDEX IDX_163233B42679C92 (grado_reporte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE navitems (id INT AUTO_INCREMENT NOT NULL, nav_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, page_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, layout VARCHAR(255) NOT NULL, homepage TINYINT(1) NOT NULL, customurl VARCHAR(255) DEFAULT NULL, target VARCHAR(255) DEFAULT NULL, ordering INT NOT NULL, published TINYINT(1) DEFAULT NULL, published_at DATETIME DEFAULT NULL, INDEX IDX_77C5DA3DF03A7216 (nav_id), INDEX IDX_77C5DA3D727ACA70 (parent_id), INDEX IDX_77C5DA3DC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE servicio ADD CONSTRAINT FK_CB86F22A2E38766A FOREIGN KEY (codigo_servicio_oficial) REFERENCES servicio (codigo)");
        $this->addSql("ALTER TABLE servicio ADD CONSTRAINT FK_CB86F22AA2DCD693 FOREIGN KEY (entidad_codigo) REFERENCES entidad (codigo)");
        $this->addSql("ALTER TABLE vista_junar ADD CONSTRAINT FK_6E080871E52B6C4E FOREIGN KEY (recurso_id) REFERENCES recurso (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE reporte ADD CONSTRAINT FK_5CB121498AAA75A FOREIGN KEY (tipo_reporte_id) REFERENCES tipo_reporte (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE reporte ADD CONSTRAINT FK_5CB1214A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE reporte ADD CONSTRAINT FK_5CB1214D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE users ADD CONSTRAINT FK_1483A5E9757D38EF FOREIGN KEY (servicio_codigo) REFERENCES servicio (codigo)");
        $this->addSql("ALTER TABLE user_has_rol ADD CONSTRAINT FK_62987CC7A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)");
        $this->addSql("ALTER TABLE user_has_rol ADD CONSTRAINT FK_62987CC74BAB96C FOREIGN KEY (rol_id) REFERENCES rol (id)");
        $this->addSql("ALTER TABLE evaluacion ADD CONSTRAINT FK_DEEDCA53D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE sector ADD CONSTRAINT FK_4BA3D9E875EA9B6F FOREIGN KEY (sector_padre_codigo) REFERENCES sector (codigo)");
        $this->addSql("ALTER TABLE recurso ADD CONSTRAINT FK_B2BB3764D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE log ADD CONSTRAINT FK_8F3F68C56E470E0A FOREIGN KEY (dataset_version_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE participacion ADD CONSTRAINT FK_669B8D69F751F7C3 FOREIGN KEY (institucion) REFERENCES servicio (codigo)");
        $this->addSql("ALTER TABLE participacion_has_categoria ADD CONSTRAINT FK_A0048F25C8B79933 FOREIGN KEY (participacion_id) REFERENCES participacion (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE participacion_has_categoria ADD CONSTRAINT FK_A0048F253397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)");
        $this->addSql("ALTER TABLE descarga ADD CONSTRAINT FK_7FCFE06EE52B6C4E FOREIGN KEY (recurso_id) REFERENCES recurso (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE vista ADD CONSTRAINT FK_D1CF61CED47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE dataset ADD CONSTRAINT FK_B7A041D0449B8D71 FOREIGN KEY (primera_version_publicada) REFERENCES dataset (id)");
        $this->addSql("ALTER TABLE dataset ADD CONSTRAINT FK_B7A041D0757D38EF FOREIGN KEY (servicio_codigo) REFERENCES servicio (codigo)");
        $this->addSql("ALTER TABLE dataset ADD CONSTRAINT FK_B7A041D03A0F5A23 FOREIGN KEY (licencia_id) REFERENCES licencia (id)");
        $this->addSql("ALTER TABLE dataset ADD CONSTRAINT FK_B7A041D020E41137 FOREIGN KEY (maestro_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE dataset_has_sector ADD CONSTRAINT FK_427AE77CD47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE dataset_has_sector ADD CONSTRAINT FK_427AE77CA7EC55F7 FOREIGN KEY (sector_codigo) REFERENCES sector (codigo)");
        $this->addSql("ALTER TABLE dataset_has_tag ADD CONSTRAINT FK_1C9BC63FD47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE dataset_has_tag ADD CONSTRAINT FK_1C9BC63FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)");
        $this->addSql("ALTER TABLE dataset_has_categoria ADD CONSTRAINT FK_AC07305D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE dataset_has_categoria ADD CONSTRAINT FK_AC073053397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)");
        $this->addSql("ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC7D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE tipo_reporte ADD CONSTRAINT FK_163233B42679C92 FOREIGN KEY (grado_reporte_id) REFERENCES grado_reporte (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE navitems ADD CONSTRAINT FK_77C5DA3DF03A7216 FOREIGN KEY (nav_id) REFERENCES navs (id)");
        $this->addSql("ALTER TABLE navitems ADD CONSTRAINT FK_77C5DA3D727ACA70 FOREIGN KEY (parent_id) REFERENCES navitems (id)");
        $this->addSql("ALTER TABLE navitems ADD CONSTRAINT FK_77C5DA3DC4663E4 FOREIGN KEY (page_id) REFERENCES pages (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE servicio DROP FOREIGN KEY FK_CB86F22A2E38766A");
        $this->addSql("ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9757D38EF");
        $this->addSql("ALTER TABLE participacion DROP FOREIGN KEY FK_669B8D69F751F7C3");
        $this->addSql("ALTER TABLE dataset DROP FOREIGN KEY FK_B7A041D0757D38EF");
        $this->addSql("ALTER TABLE participacion_has_categoria DROP FOREIGN KEY FK_A0048F253397707A");
        $this->addSql("ALTER TABLE dataset_has_categoria DROP FOREIGN KEY FK_AC073053397707A");
        $this->addSql("ALTER TABLE dataset DROP FOREIGN KEY FK_B7A041D03A0F5A23");
        $this->addSql("ALTER TABLE reporte DROP FOREIGN KEY FK_5CB1214A76ED395");
        $this->addSql("ALTER TABLE user_has_rol DROP FOREIGN KEY FK_62987CC7A76ED395");
        $this->addSql("ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5A76ED395");
        $this->addSql("ALTER TABLE tipo_reporte DROP FOREIGN KEY FK_163233B42679C92");
        $this->addSql("ALTER TABLE sector DROP FOREIGN KEY FK_4BA3D9E875EA9B6F");
        $this->addSql("ALTER TABLE dataset_has_sector DROP FOREIGN KEY FK_427AE77CA7EC55F7");
        $this->addSql("ALTER TABLE dataset_has_tag DROP FOREIGN KEY FK_1C9BC63FBAD26311");
        $this->addSql("ALTER TABLE vista_junar DROP FOREIGN KEY FK_6E080871E52B6C4E");
        $this->addSql("ALTER TABLE descarga DROP FOREIGN KEY FK_7FCFE06EE52B6C4E");
        $this->addSql("ALTER TABLE participacion_has_categoria DROP FOREIGN KEY FK_A0048F25C8B79933");
        $this->addSql("ALTER TABLE reporte DROP FOREIGN KEY FK_5CB1214D47C2D1B");
        $this->addSql("ALTER TABLE evaluacion DROP FOREIGN KEY FK_DEEDCA53D47C2D1B");
        $this->addSql("ALTER TABLE recurso DROP FOREIGN KEY FK_B2BB3764D47C2D1B");
        $this->addSql("ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5D47C2D1B");
        $this->addSql("ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C56E470E0A");
        $this->addSql("ALTER TABLE vista DROP FOREIGN KEY FK_D1CF61CED47C2D1B");
        $this->addSql("ALTER TABLE dataset DROP FOREIGN KEY FK_B7A041D0449B8D71");
        $this->addSql("ALTER TABLE dataset DROP FOREIGN KEY FK_B7A041D020E41137");
        $this->addSql("ALTER TABLE dataset_has_sector DROP FOREIGN KEY FK_427AE77CD47C2D1B");
        $this->addSql("ALTER TABLE dataset_has_tag DROP FOREIGN KEY FK_1C9BC63FD47C2D1B");
        $this->addSql("ALTER TABLE dataset_has_categoria DROP FOREIGN KEY FK_AC07305D47C2D1B");
        $this->addSql("ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC7D47C2D1B");
        $this->addSql("ALTER TABLE navitems DROP FOREIGN KEY FK_77C5DA3DC4663E4");
        $this->addSql("ALTER TABLE user_has_rol DROP FOREIGN KEY FK_62987CC74BAB96C");
        $this->addSql("ALTER TABLE navitems DROP FOREIGN KEY FK_77C5DA3DF03A7216");
        $this->addSql("ALTER TABLE servicio DROP FOREIGN KEY FK_CB86F22AA2DCD693");
        $this->addSql("ALTER TABLE reporte DROP FOREIGN KEY FK_5CB121498AAA75A");
        $this->addSql("ALTER TABLE navitems DROP FOREIGN KEY FK_77C5DA3D727ACA70");
        $this->addSql("DROP TABLE servicio");
        $this->addSql("DROP TABLE categoria");
        $this->addSql("DROP TABLE vista_junar");
        $this->addSql("DROP TABLE licencia");
        $this->addSql("DROP TABLE reporte");
        $this->addSql("DROP TABLE users");
        $this->addSql("DROP TABLE user_has_rol");
        $this->addSql("DROP TABLE evaluacion");
        $this->addSql("DROP TABLE grado_reporte");
        $this->addSql("DROP TABLE sector");
        $this->addSql("DROP TABLE suscripcion");
        $this->addSql("DROP TABLE noticia");
        $this->addSql("DROP TABLE tag");
        $this->addSql("DROP TABLE email_reminder");
        $this->addSql("DROP TABLE recurso");
        $this->addSql("DROP TABLE log");
        $this->addSql("DROP TABLE participacion");
        $this->addSql("DROP TABLE participacion_has_categoria");
        $this->addSql("DROP TABLE descarga");
        $this->addSql("DROP TABLE contacto");
        $this->addSql("DROP TABLE vista");
        $this->addSql("DROP TABLE webforms");
        $this->addSql("DROP TABLE dataset");
        $this->addSql("DROP TABLE dataset_has_sector");
        $this->addSql("DROP TABLE dataset_has_tag");
        $this->addSql("DROP TABLE dataset_has_categoria");
        $this->addSql("DROP TABLE documento");
        $this->addSql("DROP TABLE pages");
        $this->addSql("DROP TABLE rol");
        $this->addSql("DROP TABLE navs");
        $this->addSql("DROP TABLE aplicacion");
        $this->addSql("DROP TABLE entidad");
        $this->addSql("DROP TABLE tipo_reporte");
        $this->addSql("DROP TABLE navitems");
    }
}
