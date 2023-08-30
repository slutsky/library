<?php

namespace Slutsky\Library\Serialization;

use Slutsky\Library\Exception\SerializationException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SerializationExceptionNormalizer implements NormalizerInterface
{
    /**
     * {@inheritDoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof SerializationException;
    }

    /**
     * {@inheritDoc}
     *
     * @param SerializationException $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'message' => $object->getMessage(),
        ];
    }
}
