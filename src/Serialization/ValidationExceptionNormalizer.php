<?php

namespace Slutsky\Library\Serialization;

use Slutsky\Library\Exception\ValidationException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ValidationExceptionNormalizer implements NormalizerInterface
{
    /**
     * {@inheritDoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ValidationException;
    }

    /**
     * {@inheritDoc}
     *
     * @param ValidationException $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $violations = [];
        foreach ($object->getViolations() as $violation) {
            /**
             * @var ConstraintViolationInterface $violation
             */
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return [
            'message' => $object->getMessage(),
            'violations' => $violations,
        ];
    }
}
