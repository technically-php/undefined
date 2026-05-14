<?php

namespace Technically;

enum Undefined
{
    case VALUE;

    /**
     * Check if the given value is `Undefined`.
     */
    public static function isUndefined(mixed $value): bool
    {
        return $value === Undefined::VALUE;
    }

    /**
     * Check if the given value is NOT `undefined`.
     *
     * This is useful for array filtering:
     *
     *     array_filter($array, Undefined::isNot(...));
     */
    public static function isNotUndefined(mixed $value): bool
    {
        return $value !== Undefined::VALUE;
    }

    /**
     * Check if the given value is null-ish (`Undefined` or `null`).
     */
    public static function isNullish(mixed $value): bool
    {
        return $value === null || $value === Undefined::VALUE;
    }

    /**
     * Check if the given value is null-ish (`Undefined` or `null`).
     */
    public static function isNotNullish(mixed $value): bool
    {
        return $value !== null && $value !== Undefined::VALUE;
    }

    /**
     * Check if the given value is empty (`Undefined` or empty()).
     */
    public static function isEmpty(mixed $value): bool
    {
        return $value === Undefined::VALUE || empty($value);
    }

    /**
     * Check if the given value is not empty (`Undefined` or empty()).
     */
    public static function isNotEmpty(mixed $value): bool
    {
        return $value !== Undefined::VALUE && ! empty($value);
    }

    /**
     * Return the first non-empty value.
     *
     * Mimics the PHP "elvis" operator: `?:` (with `Undefined` support added)
     *
     * Returns `null` if all values are empty.
     *
     * @template T
     * @param T|Undefined|null ...$values
     * @return T|null
     */
    public static function coalesce(mixed ...$values): mixed
    {
        foreach ($values as $value) {
            if ($value !== null && $value !== Undefined::VALUE && ! empty($value)) {
                return $value;
            }
        }
        return null;
    }

    /**
     * Return the first non-nullish value.
     *
     * Mimics the PHP null coalesce operator: `??` (with `Undefined` support added)
     *
     * Returns `null` if all values are nullish.
     *
     * @template T
     * @param T|Undefined|null ...$values
     * @return T|null
     */
    public static function nullishCoalesce(mixed ...$values): mixed
    {
        foreach ($values as $value) {
            if ($value !== null && $value !== Undefined::VALUE) {
                return $value;
            }
        }
        return null;
    }
}