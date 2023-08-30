<?php

namespace Slutsky\Library\Controller;

use function Symfony\Component\String\u;
use Slutsky\Library\Dto\FileUpload;
use Slutsky\Library\Repository\FileInfoRepositoryInterface;
use Slutsky\Library\Service\FileService;
use Slutsky\Library\Service\FileUploadValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    private FileService $fileService;
    private FileInfoRepositoryInterface $fileInfoRepository;
    private FileUploadValidator $fileUploadValidator;

    public function __construct(
        FileService $fileService,
        FileInfoRepositoryInterface $fileInfoRepository,
        FileUploadValidator $fileUploadValidator
    ) {
        $this->fileService = $fileService;
        $this->fileInfoRepository = $fileInfoRepository;
        $this->fileUploadValidator = $fileUploadValidator;
    }

    /**
     * @Route("/files/{id}/info", methods={"GET"})
     */
    public function getInfoAction(int $id): JsonResponse
    {
        $fileInfo = $this->fileInfoRepository->getById($id);

        return $this->json($fileInfo);
    }

    /**
     * @Route("/files/{id}", methods={"GET"}, name="download_file")
     */
    public function downloadAction(int $id): Response
    {
        $fileDownload = $this->fileService->download($id);

        return $this->file(
            $fileDownload->getStoragePath(),
            $fileDownload->getName()
        );
    }

    /**
     * @Route("/files", methods={"POST"})
     */
    public function uploadAction(Request $request): JsonResponse
    {
        $fileUpload = FileUpload::fromFile($request->files->get('file'));

        $this->fileUploadValidator->validate($fileUpload);

        $file = $this->fileService->upload(
            $fileUpload->getFile()->getClientOriginalName(),
            $fileUpload->getFile()->getRealPath(),
        );

        return $this->json($file);
    }
}
