<?php

/*
 * This file is part of the Webmozarts Common package.
 *
 * (c) Webmozarts GmbH <office@webmozarts.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fidry\Console\Generator;

use function mb_strrpos;
use function Safe\substr;

final class ClassName
{
    private function __construct()
    {
    }

    /**
     * Strips the namespace off a fully-qualified class name. E.g.:
     * "Acme\Foo\Bar" -> "Bar".
     *
     * @param class-string $className
     */
    public static function getShortClassName(string $className): string
    {
        if (false !== ($pos = mb_strrpos($className, '\\'))) {
            return substr($className, $pos + 1);
        }

        return $className;
    }
}
