<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Fallback\Common;

interface FallbackInterface
{
    /**
     * Calls the callable and returns the result.
     *
     * @param mixed ...$parameters
     *
     * @return mixed
     */
    public function __invoke(...$parameters);
}
