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

namespace Fidry\Console;

use function trigger_deprecation;

/**
 * @codeCoverageIgnore
 * @internal
 */
final class Deprecation
{
    /**
     * @param string $message The message of the deprecation
     * @param mixed  ...$args Values to insert in the message using printf() formatting
     */
    public static function trigger(string $message, string $version, mixed ...$args): void
    {
        trigger_deprecation(
            'fidry/console',
            $version,
            $message,
            $args,
        );
    }

    private function __construct()
    {
    }
}
