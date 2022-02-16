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

namespace Fidry\Console\Tests\Generator;

use Fidry\Console\Generator\GettersGenerator;
use Fidry\Console\Generator\ParameterType;
use Fidry\Console\Type\BooleanType;
use Fidry\Console\Type\InputType;
use Fidry\Console\Type\StringType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Generator\GettersGenerator
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

            use Fidry\Console\Type\TypeFactory;

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
                        \Fidry\Console\Type\StringType::class,
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
                        \Fidry\Console\Type\BooleanType::class,
                    ]);
            
                    return $type->castValue($argument);
                }

            }
            PHP,
        ];
    }
}
