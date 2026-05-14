<?php

namespace Technically;

enum Undefined
{
    case VALUE;

    /**
     * Check if the given value is `Undefined`.
     *
     * @param mixed $value
     * @return bool
     */
    public static function is(mixed $value): bool
    {
        return $value === Undefined::VALUE;
    }

    /**
     * Check if the given value is NOT `undefined`.
     *
     * This is useful for array filtering:
     *
     *     array_filter($array, Undefined::isNot(...));
     *
     * @param mixed $value
     * @return bool
     */
    public static function isNot(mixed $value): bool
    {
        return $value !== Undefined::VALUE;
    }

    /**
     * Check if the given value is empty (`null` or `Undefined`).
     *
     * @param mixed $value
     * @return bool
     */
    public static function empty(mixed $value): bool
    {
        return $value === null || $value === Undefined::VALUE;
    }

    /**
     * Return the first non-empty (neither `null` nor `Undefined`) value.
     * Returns `null` if all values are empty.
     *
     * @template T
     * @param T|Undefined|null ...$values
     * @return T|null
     */
    public static function coalesce(mixed ...$values): mixed
    {
        foreach ($values as $value) {
            if ($value !== null && $value !== Undefined::VALUE) {
                return $value;
            }
        }
        return null;
    }
}