<?php

namespace Slutsky\Library\Serialization;

use Slutsky\Library\Exception\NotFoundException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class NotFoundExceptionNormalizer implements NormalizerInterface
{
    /**
     * {@inheritDoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof NotFoundException;
    }

    /**
     * {@inheritDoc}
     *
     * @param NotFoundException $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'message' => $object->getMessage(),
        ];
    }
}
