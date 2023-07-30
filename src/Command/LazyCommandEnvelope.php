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

namespace Fidry\Console\Command;

// TODO: description & doc
use Closure;

final class LazyCommandEnvelope
{
    /**
     * @param Closure(): Command $factory
     */
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly Closure $factory,
    ) {
    }

    /**
     * @param class-string<LazyCommand> $commandClassName
     * @param Closure():LazyCommand     $factory
     */
    public static function wrap(string $commandClassName, Closure $factory): self
    {
        return new self(
            $commandClassName::getName(),
            $commandClassName::getDescription(),
            $factory,
        );
    }
}
