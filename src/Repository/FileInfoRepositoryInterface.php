<?php

namespace Slutsky\Library\Repository;

use Slutsky\Library\Entity\FileInfo;
use Slutsky\Library\Exception\FileInfoNotFoundException;

interface FileInfoRepositoryInterface
{
    /**
     * @throws FileInfoNotFoundException
     */
    public function getById(int $id): FileInfo;

    public function add(FileInfo $file): void;
}
