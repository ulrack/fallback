<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Fallback\Tests\Component;

use PHPUnit\Framework\TestCase;
use Ulrack\Fallback\Common\FallbackInterface;
use Ulrack\Fallback\Component\FallbackStack;
use Ulrack\Fallback\Exception\FallbackStackFailedException;
use Ulrack\Validator\Common\ValidatorInterface;

/**
 * @coversDefaultClass Ulrack\Fallback\Component\FallbackStack
 * @covers Ulrack\Fallback\Exception\FallbackException
 * @covers Ulrack\Fallback\Exception\FallbackStackFailedException
 * @covers Ulrack\Fallback\Exception\FallbackValidationFailedException
 */
class FallbackStackTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::addFallback
     * @covers ::__invoke
     */
    public function testFallbackStack(): void
    {
        $parameters = ['foo', 'bar', 'baz'];
        $fallback = $this->createMock(FallbackInterface::class);
        $fallbackTwo = $this->createMock(FallbackInterface::class);
        $fallbackThree = $this->createMock(FallbackInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);

        $stack = new FallbackStack($validator);

        $stack->addFallback($fallbackTwo, 1);
        $stack->addFallback($fallbackThree, 2);
        $stack->addFallback($fallback, 0);

        $fallback->expects(static::once())
                 ->method('__invoke')
                 ->with(...$parameters)
                 ->willReturn(1);

        $fallbackTwo->expects(static::once())
                    ->method('__invoke')
                    ->with(...$parameters)
                    ->willReturn('foo');

        $fallbackThree->expects(static::never())
                      ->method('__invoke');

        $validator->expects(static::exactly(2))
                  ->method('__invoke')
                  ->withConsecutive([1], ['foo'])
                  ->willReturnOnConsecutiveCalls(false, true);

        $this->assertEquals(
            'foo',
            $stack->__invoke(...$parameters)
        );
    }

    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::addFallback
     * @covers ::__invoke
     */
    public function testFallbackStackFailed(): void
    {
        $parameters = ['foo', 'bar', 'baz'];
        $fallback = $this->createMock(FallbackInterface::class);
        $fallbackTwo = $this->createMock(FallbackInterface::class);
        $fallbackThree = $this->createMock(FallbackInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);

        $stack = new FallbackStack($validator);

        $stack->addFallback($fallbackTwo, 1);
        $stack->addFallback($fallbackThree, 2);
        $stack->addFallback($fallback, 0);

        $fallback->expects(static::once())
                 ->method('__invoke')
                 ->with(...$parameters)
                 ->willReturn(1);

        $fallbackTwo->expects(static::once())
                    ->method('__invoke')
                    ->with(...$parameters)
                    ->willReturn(2);

        $fallbackThree->expects(static::once())
                      ->method('__invoke')
                      ->with(...$parameters)
                      ->willReturn(3);

        $validator->expects(static::exactly(3))
                  ->method('__invoke')
                  ->withConsecutive([1], [2], [3])
                  ->willReturn(false);

        $this->expectException(FallbackStackFailedException::class);
        $stack->__invoke(...$parameters);
    }
}
