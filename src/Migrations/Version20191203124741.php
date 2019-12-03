<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191203124741 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP societe, DROP nom, DROP prenom, DROP email, DROP IBAN, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE client DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE client ADD societe VARCHAR(100) NOT NULL COLLATE latin1_swedish_ci, ADD nom VARCHAR(100) NOT NULL COLLATE latin1_swedish_ci, ADD prenom VARCHAR(100) NOT NULL COLLATE latin1_swedish_ci, ADD email VARCHAR(100) NOT NULL COLLATE latin1_swedish_ci, ADD IBAN VARCHAR(500) NOT NULL COLLATE latin1_swedish_ci, CHANGE id id INT NOT NULL');
    }
}
