<?php

use Technically\Undefined;

describe('Undefined', function (): void {
    it('should allow using it for a typed argument with default undefined value', function (): void {
        $hello = function (string | Undefined $name = Undefined::VALUE) {
            if ($name === Undefined::VALUE) {
                return 'Hello dude!';
            }
            return "Hello {$name}!";
        };

        expect($hello())->toBe('Hello dude!');
        expect($hello('Ivan'))->toBe('Hello Ivan!');
    });

    describe('::isUndefined()', function (): void {
        it('should check if value is undefined', function (): void {
            expect(Undefined::isUndefined(Undefined::VALUE))->toBeTrue();
            expect(Undefined::isUndefined(null))->toBeFalse();
            expect(Undefined::isUndefined('undefined'))->toBeFalse();
        });
    });

    describe('::isNotUndefined()', function (): void {
        it('should check if value is not undefined', function (): void {
            expect(Undefined::isNotUndefined(Undefined::VALUE))->toBeFalse();
            expect(Undefined::isNotUndefined(null))->toBeTrue();
            expect(Undefined::isNotUndefined('undefined'))->toBeTrue();
        });

        it('should allow filtering arrays', function (): void {
            $array = array_filter([Undefined::VALUE, null, 'hello', 'world'], Undefined::isNotUndefined(...));
            expect($array)->toEqualCanonicalizing([null, 'hello', 'world']);
        });
    });

    describe('::isNullish()', function (): void {
        it('should check if value is nullish (`Undefined` or `null`)', function (): void {
            expect(Undefined::isNullish(Undefined::VALUE))->toBeTrue();
            expect(Undefined::isNullish(null))->toBeTrue();
            expect(Undefined::isNullish(''))->toBeFalse();
            expect(Undefined::isNullish(false))->toBeFalse();
            expect(Undefined::isNullish([]))->toBeFalse();
        });
    });

    describe('::isNotNullish()', function (): void {
        it('should check if value is not nullish (`Undefined` or `null`)', function (): void {
            expect(Undefined::isNotNullish(Undefined::VALUE))->toBeFalse();
            expect(Undefined::isNotNullish(null))->toBeFalse();
            expect(Undefined::isNotNullish(''))->toBeTrue();
            expect(Undefined::isNotNullish(false))->toBeTrue();
            expect(Undefined::isNotNullish([]))->toBeTrue();
        });

        it('should allow filtering arrays', function (): void {
            $array = array_filter([Undefined::VALUE, null, 'hello', 'world'], Undefined::isNotNullish(...));
            expect($array)->toEqualCanonicalizing(['hello', 'world']);
        });
    });

    describe('::isEmpty()', function (): void {
        it('should check if value is empty', function (): void {
            expect(Undefined::isEmpty(Undefined::VALUE))->toBeTrue();

            expect(Undefined::isEmpty(null))->toBeTrue();
            expect(Undefined::isEmpty(false))->toBeTrue();
            expect(Undefined::isEmpty(''))->toBeTrue();
            expect(Undefined::isEmpty('0'))->toBeTrue('The standard PHP empty() function treats "0" as empty. We follow that behavior.');
            expect(Undefined::isEmpty([]))->toBeTrue();

            expect(Undefined::isEmpty('hello'))->toBeFalse();
            expect(Undefined::isEmpty(true))->toBeFalse();
            expect(Undefined::isEmpty(1))->toBeFalse();
            expect(Undefined::isEmpty(['']))->toBeFalse();
        });
    });

    describe('::isNotEmpty()', function (): void {
        it('should check if value is not empty', function (): void {
            expect(Undefined::isNotEmpty(Undefined::VALUE))->toBeFalse();

            expect(Undefined::isNotEmpty(null))->toBeFalse();
            expect(Undefined::isNotEmpty(false))->toBeFalse();
            expect(Undefined::isNotEmpty(''))->toBeFalse();
            expect(Undefined::isNotEmpty('0'))->toBeFalse('The standard PHP empty() function treats "0" as empty. We follow that behavior.');
            expect(Undefined::isNotEmpty([]))->toBeFalse();

            expect(Undefined::isNotEmpty('hello'))->toBeTrue();
            expect(Undefined::isNotEmpty(true))->toBeTrue();
            expect(Undefined::isNotEmpty(1))->toBeTrue();
            expect(Undefined::isNotEmpty(['']))->toBeTrue();
        });

        it('should allow filtering arrays', function (): void {
            $array = array_filter([Undefined::VALUE, null, 0, false, [], '0', 'hello', 'world'], Undefined::isNotEmpty(...));
            expect($array)->toEqualCanonicalizing(['hello', 'world']);
        });
    });

    describe('::coalesce()', function (): void {
        it('should return the first non-empty value', function (): void {
            expect(Undefined::coalesce(Undefined::VALUE, null, 0, false, [], '0', 'hello'))->toBe('hello');
        });

        it('should return null if all values are empty', function (): void {
            expect(Undefined::coalesce(Undefined::VALUE, null, 0, false, [], '0'))->toBeNull();
        });
    });

    describe('::nullishCoalesce()', function () {
        it('should return the first non-nullish value', function () {
            expect(Undefined::nullishCoalesce(Undefined::VALUE, null, 0, false, [], '0', 'hello'))->toBe(0);
        });

        it('should return null if all values are nullish', function () {
            expect(Undefined::nullishCoalesce(Undefined::VALUE, null, null, Undefined::VALUE))->toBeNull();
        });
    });
});
