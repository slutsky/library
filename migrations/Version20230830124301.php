<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230830124301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create book table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE book (
                id INT AUTO_INCREMENT NOT NULL,
                cover_id INT DEFAULT NULL,
                name VARCHAR(255) NOT NULL,
                description VARCHAR(1000) NOT NULL,
                published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                INDEX IDX_CBE5A331922726E9 (cover_id),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE book_author (
                book_id INT NOT NULL,
                author_id INT NOT NULL,
                INDEX IDX_9478D34516A2B381 (book_id),
                INDEX IDX_9478D345F675F31B (author_id),
                PRIMARY KEY(book_id, author_id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB'
        );

        $this->addSql(
            'ALTER TABLE book ADD CONSTRAINT FK_CBE5A331922726E9
            FOREIGN KEY (cover_id) REFERENCES file_info (id)'
        );

        $this->addSql(
            'ALTER TABLE book_author ADD CONSTRAINT FK_9478D34516A2B381
            FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE'
        );

        $this->addSql(
            'ALTER TABLE book_author ADD CONSTRAINT FK_9478D345F675F31B
            FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331922726E9');
        $this->addSql('ALTER TABLE book_author DROP FOREIGN KEY FK_9478D34516A2B381');
        $this->addSql('ALTER TABLE book_author DROP FOREIGN KEY FK_9478D345F675F31B');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_author');
    }
}
