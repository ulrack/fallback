<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Fallback\Common;

interface FallbackStackInterface
{
    /**
     * Adds a fallback to the fallback stack.
     *
     * @param FallbackInterface $fallback
     * @param integer           $position
     *
     * @return void
     */
    public function addFallback(
        FallbackInterface $fallback,
        int $position = 0
    ): void;

    /**
     * Invokes the stack in order, untill a valid result is returned.
     *
     * @param mixed ...$parameters
     *
     * @return mixed
     */
    public function __invoke(...$parameters);
}
