[![Build Status](https://travis-ci.com/ulrack/fallback.svg?branch=master)](https://travis-ci.com/ulrack/fallback)

# Ulrack Fallback

This package contains an implementation for implementing a fallback system
within a PHP application.

## Installation

To install the package run the following command:

```
composer require ulrack/fallback
```

## Usage

A single fallback consists of one [FallbackStack](src/Component/FallbackStack.php)
with multiple [Fallback](src/Component/Fallback.php)s.

### Creating a Fallback

A fallback can be created by providing it with a callable, a (optional) validator
and a (optional) set of parameters. The callable will be executed when it is
reached inside the stack. The validator (see package: ulrack/validator)
will be used to verify the output of the callable. The parameters are variadic
and will override the parameters send by the stack.

An implementation would look like:

```php
<?php

use Ulrack\Fallback\Component\Fallback;
use Ulrack\Validator\Component\Logical\ConstValidator;

$class = new class {
    /**
     * Returns the input.
     *
     * @param string $input
     *
     * @return string
     */
    public function foo(string $input): string
    {
        return $input;
    }
};

$validator = new ConstValidator('bar');

$fallback = new Fallback([$class, 'foo'], $validator);
```

The fallback stack can be created after this. The fallback stack takes a
validator as an argument. The function `addFallback` is used to add the fallback
to the stack. This function takes the Fallback and a position as its arguments.
The stack can then be invoked with a set of parameters.

```php
<?php

use Ulrack\Fallback\Component\FallbackStack;
use Ulrack\Validator\Component\Type\StringValidator;

$validator = new StringValidator();

$fallbackStack = new FallbackStack($validator);

$fallbackStack->addFallback($fallback, 0);

$fallbackStack('bar');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## MIT License

Copyright (c) 2019 GrizzIT

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
