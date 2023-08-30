<?php

namespace Slutsky\Library\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AuthorChange
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
