<?php declare(strict_types=1);

namespace SfpCodingStandardTest\Sniffs\Di;

use SfpCodingStandard\Sniffs\Di\ForbiddenInstantiationSniff;
use SfpCodingStandardTest\Sniffs\Di\Fixture\FooInterface;
use SfpCodingStandardTest\Sniffs\Di\Fixture\PdoFactory;
use SlevomatCodingStandard\Sniffs\TestCase;

final class ForbiddenInstantiationSniffTest extends TestCase
{
    use SfpSniffClassNameGetterTrait;

    /**
     * @test
     */
    public function nonForbiddenShouldNotRaiseError() :void
    {
        $filePath = __DIR__ . '/Fixture/ViolateInstantiation.php';
        $report = static::checkFile($filePath, [], $codesToCheck = []);
        self::assertSame(0, $report->getErrorCount());
    }

    /**
     * @test
     *
     * @dataProvider provideForbiddenInstantiations
     */
    public function forbiddenShouldRaiseError(int $expectedErrorCount, ?int $errorLine, array $sniffProperties) :void
    {
        $filePath = __DIR__ . '/Fixture/ViolateInstantiation.php';

        $report = static::checkFile($filePath, $sniffProperties, $codesToCheck = []);

        self::assertSame($expectedErrorCount, $report->getErrorCount());
        self::assertSniffError($report, $errorLine, ForbiddenInstantiationSniff::VIOLATE_FORBIDDEN_INSTANTIATION_AGAINST_LIST);
    }

    /**
     * @test
     */
    public function dontRaiseErrorIsInFactory() :void
    {
        $filePath = __DIR__ . '/Fixture/PdoFactory.php';

        $sniffProperties = [
            'forbiddenInstantiations' => [
                PdoFactory::class => \PDO::class
            ],
        ];

        $report = static::checkFile($filePath, $sniffProperties, $codesToCheck = []);
        self::assertSame(0, $report->getErrorCount());
    }

    public function provideForbiddenInstantiations() : array
    {
        return [
            'forbiddenClass' => [
                'errorCount' => 1,
                'errorLine' => 11,
                'sniffProperties' => [
                    'forbiddenInstantiations' => [
                        'SfpTest\\DummyPdoFactory' => \PDO::class
                    ]
                ]
            ],
            'forbiddenIsA' => [
                'errorCount' => 1,
                'errorLine' => 13,
                'sniffProperties' => [
                    'forbiddenInstantiations' => [
                        'SfpTest\\FooFactory' => FooInterface::class
                    ]
                ]
            ],
        ];
    }
}