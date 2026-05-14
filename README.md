# Technically\Undefined

Technically\Undefined is a clever way of emulating `undefined` values in PHP8.
Thanks to enums and union types we can finally have `undefined` in PHP.

With arrays, you can distinguish between `null` value and _missing key_. 
However, it is not an option for class properties or typed method parameters.

For typed properties and method parameters you would normally use `null` as
"no value". But what do you do if `null` is also a valid value? Then you need 
another "nullish" thing to use instead. Like `undefined` in JavaScript.

## Usage

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
        public string $line2,
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
    'Sherlock Holmes',
    '221B Baker Street',
    '',
    'London',
    'England',
    'NW1 6XE',
    'United Kingdom'
);

$address = $address->with(name: 'Dr. John H. Watson');
```


## License

This project is licensed under the terms of the [MIT license](./LICENSE).

## Credits

Authored by 👾 [Ivan Voskoboinyk](https://www.voskoboinyk.com/).
