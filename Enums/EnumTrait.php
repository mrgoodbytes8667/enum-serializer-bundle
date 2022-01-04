<?php

namespace Bytes\EnumSerializerBundle\Enums;

use BadMethodCallException;
use JetBrains\PhpStorm\Deprecated;
use TypeError;

/**
 * @method static from(int|string $value)
 */
trait EnumTrait
{
    /**
     * Helper method to determine if a supplied value is an enum value
     * @param string|int $value
     *
     * @return bool
     */
    public static function isValid($value): bool
    {
        try {
            $enum = static::from($value);
            return true;
        } catch (BadMethodCallException|TypeError $exception) {
            return false;
        }
    }

    /**
     * @param string|int $value
     *
     * @return static
     */
    #[Deprecated(reason: 'since 1.3.1, use from() instead', replacement: '%class%::from(%parameter0%)')]
    public static function make($value): Enum
    {
        return static::from($value);
    }

    /**
     * @return string[]
     */
    #[Deprecated(reason: 'since 1.6.0, use "cases()" instead.', replacement: '%class%::cases()')]
    public static function getLabels(): array
    {
        trigger_deprecation('mrgoodbytes8667/enum-serializer-bundle', '1.6.0', 'Using "%s" is deprecated, use "%s()" instead.', __METHOD__, 'cases');
        return static::toLabels();
    }

    #[Deprecated(reason: 'since 1.6.0, use "cases()" instead.', replacement: '%class%::cases()')]
    public static function toLabels(): array
    {
        trigger_deprecation('mrgoodbytes8667/enum-serializer-bundle', '1.6.0', 'Using "%s" is deprecated, use "%s()" instead.', __METHOD__, 'cases');
        return parent::toLabels(); // TODO: Change the autogenerated stub
    }

    /**
     * @return string[]|int[]
     */
    #[Deprecated(reason: 'since 1.6.0, use "cases()" instead.', replacement: '%class%::cases()')]
    public static function getValues(): array
    {
        trigger_deprecation('mrgoodbytes8667/enum-serializer-bundle', '1.6.0', 'Using "%s" is deprecated, use "%s()" instead.', __METHOD__, 'cases');
        return static::toValues();
    }

    #[Deprecated(reason: 'since 1.6.0, use "cases()" instead.', replacement: '%class%::cases()')]
    public static function toValues(): array
    {
        trigger_deprecation('mrgoodbytes8667/enum-serializer-bundle', '1.6.0', 'Using "%s" is deprecated, use "%s()" instead.', __METHOD__, 'cases');
        return parent::toValues(); // TODO: Change the autogenerated stub
    }

    #[Deprecated(reason: 'since 1.6.0, use "cases()" instead.', replacement: '%class%::cases()')]
    public static function toArray(): array
    {
        trigger_deprecation('mrgoodbytes8667/enum-serializer-bundle', '1.6.0', 'Using "%s" is deprecated, use "%s()" instead.', __METHOD__, 'cases');
        return parent::toArray(); // TODO: Change the autogenerated stub
    }
}