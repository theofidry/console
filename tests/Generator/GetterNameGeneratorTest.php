<?php

declare(strict_types=1);

namespace Fidry\Console\Tests\Generator;

use Fidry\Console\Generator\GetterNameGenerator;
use Fidry\Console\Generator\ParameterType;
use Fidry\Console\Generator\Type\BooleanType;
use Fidry\Console\Generator\Type\InputType;
use Fidry\Console\Generator\Type\ListType;
use Fidry\Console\Generator\Type\NullableType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fidry\Console\Generator\GetterNameGenerator
 */
final class GetterNameGeneratorTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function test_it_can_generate_name(InputType $type, string $expected): void
    {
        $actual = GetterNameGenerator::generateMethodName(
            ParameterType::ARGUMENT,
            $type->getTypeClassNames(),
        );
        
        self::assertSame($expected, $actual);
    }
    
    public static function typeProvider(): iterable
    {
        yield 'singular type' => [
            new BooleanType(),
            'getBooleanArgument',
        ];

        yield 'composed type' => [
            new NullableType(
                new BooleanType(),
            ),
            'getNullableBooleanArgument',
        ];

        yield 'deep composed type' => [
            new NullableType(
                new ListType(
                    new BooleanType(),
                ),
            ),
            'getNullableBooleanListArgument',
        ];
    }
}
