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

namespace Fidry\Console\Tests\Internal\Generator;

use Fidry\Console\Internal\Generator\GettersGenerator;
use Fidry\Console\Internal\Generator\ParameterType;
use Fidry\Console\Internal\Type\BooleanType;
use Fidry\Console\Internal\Type\InputType;
use Fidry\Console\Internal\Type\StringType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Internal\Generator\GettersGenerator
 */
final class GettersGeneratorTest extends TestCase
{
    /**
     * @dataProvider typesProvider
     *
     * @param non-empty-list<InputType>                           $types
     * @param list<ParameterType::ARGUMENT|ParameterType::OPTION> $parameterTypes
     */
    public function test_it_can_generate_getters_for_the_given_types_and_parameters(
        array $types,
        array $parameterTypes,
        string $expected
    ): void {
        $actual = GettersGenerator::generate($types, $parameterTypes);

        self::assertSame($expected, $actual);
    }

    public static function typesProvider(): iterable
    {
        yield 'nominal' => [
            [new StringType(), new BooleanType()],
            [ParameterType::ARGUMENT],
            <<<'PHP'
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

            use Fidry\Console\Internal\Type\TypeFactory;

            /**
             * @internal
             */
            trait IOGetters
            {

                /**
                 * @return string
                 */
                public function getStringArgument(string $name): string
                {
                    $argument = $this->getLegacyArgument($name);

                    $type = TypeFactory::createTypeFromClassNames([
                        \Fidry\Console\Internal\Type\StringType::class,
                    ]);

                    return $type->castValue($argument);
                }

                /**
                 * @return bool
                 */
                public function getBooleanArgument(string $name): bool
                {
                    $argument = $this->getLegacyArgument($name);
            
                    $type = TypeFactory::createTypeFromClassNames([
                        \Fidry\Console\Internal\Type\BooleanType::class,
                    ]);
            
                    return $type->castValue($argument);
                }

            }
            PHP,
        ];
    }
}