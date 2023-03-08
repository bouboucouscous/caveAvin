<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308163417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cave_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE robe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE teneur_en_sucre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cave (id INT NOT NULL, id_user_id INT NOT NULL, date_mise_encave DATE NOT NULL, date_sortie DATE DEFAULT NULL, note INT DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57F6D4179F37AE5 ON cave (id_user_id)');
        $this->addSql('CREATE TABLE cave_vin (cave_id INT NOT NULL, vin_id INT NOT NULL, PRIMARY KEY(cave_id, vin_id))');
        $this->addSql('CREATE INDEX IDX_4709BE267F05B85 ON cave_vin (cave_id)');
        $this->addSql('CREATE INDEX IDX_4709BE26BA62C651 ON cave_vin (vin_id)');
        $this->addSql('CREATE TABLE robe (id INT NOT NULL, nom VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE teneur_en_sucre (id INT NOT NULL, nom VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, name VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nombre_de_place_dans_cave INT NOT NULL, username VARCHAR(255) NOT NULL, photo_profil VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B35E237E06 ON utilisateur (name)');
        $this->addSql('CREATE TABLE vin (id INT NOT NULL, robe_id INT NOT NULL, teneur_en_sucre_id INT NOT NULL, nom VARCHAR(50) NOT NULL, année DATE NOT NULL, cépage VARCHAR(50) NOT NULL, gout VARCHAR(255) DEFAULT NULL, format_cl INT NOT NULL, domain VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B108514169339CCD ON vin (robe_id)');
        $this->addSql('CREATE INDEX IDX_B1085141F7225AF6 ON vin (teneur_en_sucre_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE cave ADD CONSTRAINT FK_57F6D4179F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cave_vin ADD CONSTRAINT FK_4709BE267F05B85 FOREIGN KEY (cave_id) REFERENCES cave (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cave_vin ADD CONSTRAINT FK_4709BE26BA62C651 FOREIGN KEY (vin_id) REFERENCES vin (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vin ADD CONSTRAINT FK_B108514169339CCD FOREIGN KEY (robe_id) REFERENCES robe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vin ADD CONSTRAINT FK_B1085141F7225AF6 FOREIGN KEY (teneur_en_sucre_id) REFERENCES teneur_en_sucre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cave_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE robe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE teneur_en_sucre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vin_id_seq CASCADE');
        $this->addSql('ALTER TABLE cave DROP CONSTRAINT FK_57F6D4179F37AE5');
        $this->addSql('ALTER TABLE cave_vin DROP CONSTRAINT FK_4709BE267F05B85');
        $this->addSql('ALTER TABLE cave_vin DROP CONSTRAINT FK_4709BE26BA62C651');
        $this->addSql('ALTER TABLE vin DROP CONSTRAINT FK_B108514169339CCD');
        $this->addSql('ALTER TABLE vin DROP CONSTRAINT FK_B1085141F7225AF6');
        $this->addSql('DROP TABLE cave');
        $this->addSql('DROP TABLE cave_vin');
        $this->addSql('DROP TABLE robe');
        $this->addSql('DROP TABLE teneur_en_sucre');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vin');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
