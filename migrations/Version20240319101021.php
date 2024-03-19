<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319101021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, complement VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postalcode VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, phonenumber VARCHAR(255) DEFAULT NULL, isstatusdelivery TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', isstatuspayment TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_3781EC10A76ED395 (user_id), UNIQUE INDEX UNIQ_3781EC104C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC104C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE product ADD delivery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12136921 ON product (delivery_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12136921');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10A76ED395');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC104C3A3BB');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP INDEX IDX_D34A04AD12136921 ON product');
        $this->addSql('ALTER TABLE product DROP delivery_id');
    }
}
