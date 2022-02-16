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

namespace Fidry\Console\Generator;

use function Safe\file_put_contents;

/**
 * @private
 */
final class IOGettersDumper
{
    private const TARGET_PATH = __DIR__.'/../IOGetters.php';

    public static function generate(): void
    {
        $content = GettersGenerator::generate(
            TypeMap::provideTypes(),
            ParameterType::ALL,
        );

        file_put_contents(self::TARGET_PATH, $content);
    }
}
