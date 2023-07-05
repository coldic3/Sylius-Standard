<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705130900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_library (book_id INT NOT NULL, library_id INT NOT NULL, INDEX IDX_32A0B02A16A2B381 (book_id), INDEX IDX_32A0B02AFE2541D7 (library_id), PRIMARY KEY(book_id, library_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Library (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_library ADD CONSTRAINT FK_32A0B02A16A2B381 FOREIGN KEY (book_id) REFERENCES Book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_library ADD CONSTRAINT FK_32A0B02AFE2541D7 FOREIGN KEY (library_id) REFERENCES Library (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_library DROP FOREIGN KEY FK_32A0B02A16A2B381');
        $this->addSql('ALTER TABLE book_library DROP FOREIGN KEY FK_32A0B02AFE2541D7');
        $this->addSql('DROP TABLE book_library');
        $this->addSql('DROP TABLE Library');
    }
}
