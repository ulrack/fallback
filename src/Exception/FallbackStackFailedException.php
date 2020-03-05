<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Fallback\Exception;

class FallbackStackFailedException extends FallbackException
{
    /**
     * Constructor.
     *
     * @param FallbackFailedException[] $fallbacks
     */
    public function __construct(array $fallbacks)
    {
        $i = 0;
        $stack = [];
        foreach ($fallbacks as $fallback) {
            $stack[] = sprintf(
                'Call #%d failed: %s',
                $i,
                $fallback->getMessage()
            );
            $i++;
        }

        parent::__construct(
            sprintf(
                "Stack failed:\n%s",
                implode("\n", $stack)
            )
        );
    }
}
