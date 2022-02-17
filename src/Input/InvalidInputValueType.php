<?php

/*
 * This file is part of the Fidry\Console package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fidry\Console\Input;

use Symfony\Component\Console\Exception\InvalidArgumentException as ConsoleInvalidArgumentException;
use Webmozart\Assert\InvalidArgumentException as AssertInvalidArgumentException;

final class InvalidInputValueType extends ConsoleInvalidArgumentException
{
    public static function fromAssert(AssertInvalidArgumentException $exception): self
    {
        return new self(
            $exception->getMessage(),
            (int) $exception->getCode(),
            $exception,
        );
    }
}
