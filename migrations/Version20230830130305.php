<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230830130305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add number of books to author';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE author ADD number_of_books INT DEFAULT 0 NOT NULL');

        $this->addSql(
            'UPDATE author a SET number_of_books = (
                SELECT COUNT(*) FROM book b
                INNER JOIN book_author ba ON b.id = ba.book_id AND ba.author_id = a.id
            )'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE author DROP number_of_books');
    }
}
