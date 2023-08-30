<?php

namespace Slutsky\Library\Serialization;

use Slutsky\Library\Entity\FileInfo;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FileInfoNormalizer implements NormalizerInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof FileInfo;
    }

    /**
     * {@inheritDoc}
     *
     * @param FileInfo $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'path' => $this->urlGenerator->generate('download_file', [
                'id' => $object->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ];
    }
}
