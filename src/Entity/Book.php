<?php

namespace Slutsky\Library\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Book
{
    private ?int $id = null;
    private string $name;
    private string $description;
    private FileInfo $cover;
    private DateTimeImmutable $publishedAt;

    /**
     * @var Collection&Author[]
     */
    private Collection $authors;

    /**
     * @param Author[] $authors
     */
    public function __construct(
        string $name,
        array $authors,
        string $description,
        FileInfo $cover,
        DateTimeImmutable $publishedAt
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->cover = $cover;
        $this->publishedAt = $publishedAt;

        $this->authors = new ArrayCollection($authors);
    }

    /**
     * @param Author[] $authors
     */
    public function update(
        string $name,
        array $authors,
        string $description,
        FileInfo $cover,
        DateTimeImmutable $publishedAt
    ): void {
        $this->name = $name;
        $this->description = $description;
        $this->cover = $cover;
        $this->publishedAt = $publishedAt;

        $this->authors->clear();
        foreach ($authors as $author) {
            $this->authors->add($author);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Author[]
     */
    public function getAuthors(): array
    {
        return $this->authors->toArray();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCover(): FileInfo
    {
        return $this->cover;
    }

    public function getPublishedAt(): DateTimeImmutable
    {
        return $this->publishedAt;
    }
}
