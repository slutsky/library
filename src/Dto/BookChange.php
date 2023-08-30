<?php

namespace Slutsky\Library\Dto;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class BookChange
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @Assert\Type("array")
     * @Assert\NotBlank
     * @Assert\Count(min=1)
     * @Assert\All(
     *     @Assert\Type("int")
     * )
     */
    private $authors;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @Assert\Type("int")
     * @Assert\NotBlank
     */
    private int $cover;

    /**
     * @Assert\NotBlank
     */
    private DateTimeImmutable $publishedAt;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return int[]
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param int[] $author
     */
    public function setAuthors($authors): void
    {
        $this->authors = $authors;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getCover(): int
    {
        return $this->cover;
    }

    public function setCover(int $cover): void
    {
        $this->cover = $cover;
    }

    public function getPublishedAt(): DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(DateTimeImmutable $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }
}
