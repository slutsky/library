<?php

namespace Slutsky\Library\Dto;

class FileDownload
{
    private string $name;
    private string $storagePath;

    public function __construct(
        string $name,
        string $storagePath
    ) {
        $this->name = $name;
        $this->storagePath = $storagePath;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }
}
