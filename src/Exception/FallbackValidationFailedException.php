<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Fallback\Exception;

use Ulrack\Validator\Common\ValidatorInterface;

class FallbackValidationFailedException extends FallbackException
{
    /**
     * Constructor.
     *
     * @param ValidatorInterface $callable
     * @param mixed              $return
     */
    public function __construct(ValidatorInterface $validator, $return)
    {
        parent::__construct(
            sprintf(
                'Callback stack validator failed for %s with %s.',
                gettype($return),
                get_class($validator)
            )
        );
    }
}
