<?php

namespace Slutsky\Library\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Slutsky\Library\Entity\FileInfo;
use Slutsky\Library\Exception\FileInfoNotFoundException;

class FileInfoRepository extends ServiceEntityRepository implements
    FileInfoRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileInfo::class);
    }

    /**
     * @throws FileInfoNotFoundException
     */
    public function getById(int $id): FileInfo
    {
        $file = $this->find($id);

        if (null === $file) {
            throw FileInfoNotFoundException::create();
        }

        return $file;
    }

    public function add(FileInfo $file): void
    {
        $this->getEntityManager()->persist($file);
    }
}
