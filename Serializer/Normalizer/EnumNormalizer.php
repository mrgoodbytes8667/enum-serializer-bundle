<?php

namespace Bytes\EnumSerializerBundle\Serializer\Normalizer;

use Bytes\EnumSerializerBundle\Enums\Enum;
use Spatie\Enum\Enum as EnumParent;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class EnumNormalizer
 * @package Bytes\EnumBundle\Serializer\Normalizer
 */
class EnumNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface, ContextAwareNormalizerInterface, DenormalizerInterface
{
    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param mixed $object Object to normalize
     * @param string|null $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|int|float|bool|\ArrayObject|null \ArrayObject is used to make sure an empty object is encoded as an object not an array
     *
     * @throws InvalidArgumentException   Occurs when the object given is not a supported type for the normalizer
     * @throws CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws LogicException             Occurs when the normalizer is not called in an expected context
     * @throws ExceptionInterface         Occurs for all the other cases of errors
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        if ($object instanceof Enum) {
            return $object->jsonSerialize();
        } else {
            return [
                'label' => $object->label,
                'value' => $object->value
            ];
        }
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string|null $format The format being (de-)serialized from or into
     * @param array $context options that normalizers have access to
     *
     * @return bool
     */
    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof EnumParent;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data Data to restore
     * @param string $type The expected class to instantiate
     * @param string|null $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     *
     * @return EnumParent
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     * @throws ExceptionInterface       Occurs for all the other cases of errors
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        if(is_array($data)) {
            if(array_key_exists('value', $data)) {
                $data = $data['value'];
            }
        }
        try {
            return new $type($data);
        } catch (BadMethodCallException | \TypeError $exception) {
            throw new UnexpectedValueException(sprintf("The value %s is not a valid value for %s", is_string($data) || is_numeric($data) ? (string) $data : '...', $type));
        }
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from
     * @param string $type The class to which the data should be denormalized
     * @param string|null $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return is_subclass_of($type, EnumParent::class);
    }

    /**
     * @return bool
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
