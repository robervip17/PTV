<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200424002903 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE coches (id INT AUTO_INCREMENT NOT NULL, marca VARCHAR(255) NOT NULL, modelo VARCHAR(255) NOT NULL, observaciones LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reparaciones (id INT AUTO_INCREMENT NOT NULL, coche_id INT DEFAULT NULL, tipo_reparacion VARCHAR(255) NOT NULL, realizacion LONGTEXT NOT NULL, observaciones LONGTEXT DEFAULT NULL, INDEX IDX_60AF46EF4621E56 (coche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sesion (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, fecha_sesion DATETIME NOT NULL, UNIQUE INDEX UNIQ_1B45E21BDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, dni VARCHAR(9) NOT NULL, nombre_completo VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_coches (user_id INT NOT NULL, coches_id INT NOT NULL, INDEX IDX_FF435AE7A76ED395 (user_id), INDEX IDX_FF435AE7658D2BFA (coches_id), PRIMARY KEY(user_id, coches_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reparaciones ADD CONSTRAINT FK_60AF46EF4621E56 FOREIGN KEY (coche_id) REFERENCES coches (id)');
        $this->addSql('ALTER TABLE sesion ADD CONSTRAINT FK_1B45E21BDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_coches ADD CONSTRAINT FK_FF435AE7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_coches ADD CONSTRAINT FK_FF435AE7658D2BFA FOREIGN KEY (coches_id) REFERENCES coches (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reparaciones DROP FOREIGN KEY FK_60AF46EF4621E56');
        $this->addSql('ALTER TABLE user_coches DROP FOREIGN KEY FK_FF435AE7658D2BFA');
        $this->addSql('ALTER TABLE sesion DROP FOREIGN KEY FK_1B45E21BDB38439E');
        $this->addSql('ALTER TABLE user_coches DROP FOREIGN KEY FK_FF435AE7A76ED395');
        $this->addSql('DROP TABLE coches');
        $this->addSql('DROP TABLE reparaciones');
        $this->addSql('DROP TABLE sesion');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_coches');
    }
}
