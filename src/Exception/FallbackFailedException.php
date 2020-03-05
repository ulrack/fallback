<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Fallback\Exception;

class FallbackFailedException extends FallbackException
{
    /**
     * Constructor.
     *
     * @param array $callable
     * @param array $parameters
     */
    public function __construct(array $callable, array $parameters)
    {
        parent::__construct(
            sprintf(
                'Callback failed for "%s", with: %s',
                implode('::', array_map(
                    function ($call): string {
                        if (is_object($call)) {
                            return get_class($call);
                        }

                        return $call;
                    },
                    $callable
                )),
                implode(', ', array_map(
                    function ($parameter): string {
                        return gettype($parameter);
                    },
                    $parameters
                ))
            )
        );
    }
}
