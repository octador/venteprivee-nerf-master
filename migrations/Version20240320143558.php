<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320143558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC104584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_3781EC104584665A ON delivery (product_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12136921');
        $this->addSql('DROP INDEX IDX_D34A04AD12136921 ON product');
        $this->addSql('ALTER TABLE product DROP delivery_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC104584665A');
        $this->addSql('DROP INDEX IDX_3781EC104584665A ON delivery');
        $this->addSql('ALTER TABLE delivery DROP product_id');
        $this->addSql('ALTER TABLE product ADD delivery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D34A04AD12136921 ON product (delivery_id)');
    }
}
