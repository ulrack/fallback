<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Fallback\Component;

use Ulrack\Fallback\Common\FallbackInterface;
use Ulrack\Fallback\Exception\FallbackFailedException;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Validator\Component\Logical\AlwaysValidator;

class Fallback implements FallbackInterface
{
    /**
     * The callable which should be invoked when this class is invoked.
     *
     * @var callable
     */
    private $callable;

    /**
     * The validator for the return type of the invocation.
     *
     * @var ValidatorInterface;
     */
    private $validator;

    /**
     * The parameters which override the parameters passed through the invocation.
     *
     * @var array
     */
    private $parameters;

    /**
     * Constructor
     *
     * @param callable           $callable
     * @param ValidatorInterface $validator
     * @param mixed           ...$parameters
     */
    public function __construct(
        callable $callable,
        ValidatorInterface $validator = null,
        ...$parameters
    ) {
        $this->callable   = $callable;
        $this->validator  = $validator ?? new AlwaysValidator(true);
        $this->parameters = $parameters;
    }

    /**
     * Calls the callable and returns the result.
     *
     * @param mixed ...$parameters
     *
     * @return mixed
     */
    public function __invoke(...$parameters)
    {
        $parameters = $this->parameters + $parameters;
        $return = ($this->callable)(...$parameters);
        if (($this->validator)($return)) {
            return $return;
        }

        throw new FallbackFailedException($this->callable, $parameters);
    }
}
