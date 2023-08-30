<?php

namespace Slutsky\Library\Service;

use Doctrine\ORM\EntityManagerInterface;
use Slutsky\Library\Dto\FileDownload;
use Slutsky\Library\Entity\FileInfo;
use Slutsky\Library\Exception\FileInfoNotFoundException;
use Slutsky\Library\Repository\FileInfoRepositoryInterface;

class FileService
{
    private EntityManagerInterface $entityManager;
    private FileInfoRepositoryInterface $fileInfoRepository;
    private string $basePath;

    public function __construct(
        EntityManagerInterface $entityManager,
        FileInfoRepositoryInterface $fileInfoRepository,
        string $basePath
    ) {
        $this->entityManager = $entityManager;
        $this->fileInfoRepository = $fileInfoRepository;
        $this->basePath = $basePath;
    }

    /**
     * @throws FileInfoNotFoundException
     */
    public function download(int $id): FileDownload
    {
        $fileInfo = $this->fileInfoRepository->getById($id);
        $storagePath = $this->basePath.'/'.$fileInfo->getPath();

        return new FileDownload($fileInfo->getName(), $storagePath);
    }

    public function upload(string $name, string $path): FileInfo
    {
        $hash = md5_file($path);
        $storagePath = $this->basePath.'/'.$hash;

        if (!file_exists($this->basePath)) {
            mkdir($this->basePath, 0755, true);
        }

        copy($path, $storagePath);

        $fileInfo = new FileInfo($hash, $name);

        $this->fileInfoRepository->add($fileInfo);

        $this->entityManager->flush();

        return $fileInfo;
    }
}
