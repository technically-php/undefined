<img src="./logo.png" alt="Project logo: image showing an empty circle with dashed border with the text next to it: Technically Undefined">

# Technically\Undefined

[![Test](https://github.com/technically-php/undefined/actions/workflows/test.yml/badge.svg)](https://github.com/technically-php/undefined/actions/workflows/test.yml)

Technically\Undefined is a clever way of emulating `undefined` values in PHP8.
Thanks to enums and union types we can finally have `undefined` in PHP.

With arrays, you can distinguish between `null` value and _missing key_. 
However, it is not an option for class properties or typed method parameters.

For typed properties and method parameters you would normally use `null` as
"no value". But what do you do if `null` is also a valid value? Then you need 
another "nullish" thing to use instead. Like `undefined` in JavaScript.

## Usage

The package provides an enum for representing `undefined` values: `Technically\Undefined`.

- You can use it to type class properties and method parameters (e.g. `string | Undefined`)
- You can refer the enum case to define default values to properties and parameters (`Undefined::VALUE`)
- There are several utility methods in the `Undefined` enum which you can use to make your code more elegant

```php
use Technically\Undefined;

function hello(string | Undefined $name = Undefined::VALUE) {
  return $name === Undefined::VALUE ? "Hello!" : "Hello, {$name}!";
} 
```

## Methods

### `::isUndefined()`

Check if the given value is `Undefined`.


### `::isNotUndefined()`

Check if the given value is not `Undefined`.

This method is particularly useful for callbacks:

```php
array_filter($array, Undefined::isNotUndefined(...))
```

### `::isNullish()`

Check if the given value is _nullish_ — either `null` or `Undefined`.


### `::isNotNullish()`

Check if the given value is not _nullish_ — neither `null` nor `Undefined`.

This method is particularly useful for callbacks:

```php
array_filter($array, Undefined::isNotNullish(...))
```

### `::isEmpty()`

Check if the given value is _empty_.

This method follows the semantics of the standard `empty()` function,
but also adds support for `Undefined` values — treating them as empty too.


### `::isNotEmpty()`

Check if the given value is not _empty_.

This method follows the semantics of the standard `empty()` function,
but also adds support for `Undefined` values — treating them as empty too.

This method is particularly useful for callbacks:

```php
array_filter($array, Undefined::isNotEmpty(...))
```

### `::coalesce()`

Return the first _non-empty_ value.

This method follows the semantics of the standard _coalesce operator_ in PHP: `?:` (aka "elvis operator"),
but also adds support for `Undefined` values — treating them as empty too.

```php
return Undefined::coalesce($delay, self::DEFAULT_DELAY);
```

### `::nullishCoalesce()`

Return the first _non-nullish_ value.

This method follows the semantics of the standard _null coalesce operator_ in PHP: `??`,
but also adds support for `Undefined` values — treating them as nullish too.

```php
return Undefined::nullishCoalesce($delay, self::DEFAULT_DELAY);
```

## Examples

### Function parameters

```php
use Technically\Undefined;

function hello(string | null | Undefined $name = Undefined::VALUE) {
    return match ($name) {
        Undefined::VALUE => 'Hello, stranger!',
        null             => 'Hello!',
        default          => "Hello, {$name}!",
    };
}
```


### Class properties

Note how `null` is a possible valid value for updating user organization:

```php
use Technically\Undefined;

final readonly class UserUpdateRequest 
{
    public function __construct(
        public string | Undefined              $name         = Undefined::VALUE,
        public string | Undefined              $email        = Undefined::VALUE,
        public Organization | null | Undefined $organization = Undefined::VALUE,
    ) {
        // Nothing
    }
}
```


### Immutable objects

With `undefined` with can have one big all-in-one "update" method for changing 
properties of an immutable object: 

```php
use Technically\Undefined;

readonly class Address {
    public function __construct(
        public string $name,
        public string $line1,
        public string $line2 = '',
        public string $city,
        public string | null $state = null,
        public string $zip,
        public string $country,
    ) {
        // Nothing
    }
    
    public function with(
        string | Undefined        $name    = Undefined::VALUE,
        string | Undefined        $line1   = Undefined::VALUE,
        string | Undefined        $line2   = Undefined::VALUE,
        string | Undefined        $city    = Undefined::VALUE,
        string | null | Undefined $state   = Undefined::VALUE,
        string | Undefined        $zip     = Undefined::VALUE,
        string | Undefined        $country = Undefined::VALUE,
    ) {
        return new self(
            name:    $name !== Undefined::VALUE    ? $name    : $this->name,
            line1:   $line1 !== Undefined::VALUE   ? $line1   : $this->line1,
            line2:   $line2 !== Undefined::VALUE   ? $line2   : $this->line2,
            city:    $city !== Undefined::VALUE    ? $city    : $this->city,
            state:   $state !== Undefined::VALUE   ? $state   : $this->state,
            zip:     $zip !== Undefined::VALUE     ? $zip     : $this->zip,
            country: $country !== Undefined::VALUE ? $country : $this->country,
        );
    }
}

$address = new Address(
    name:    'Sherlock Holmes',
    line1:   '221B Baker Street',
    city:    'London',
    zip:     'NW1 6XE',
    country: 'England',
);

$address = $address->with(name: 'Dr. John H. Watson');
```


## License

This project is licensed under the terms of the [MIT license](./LICENSE).

## Credits

Authored by 👾 [Ivan Voskoboinyk](https://www.voskoboinyk.com/).
