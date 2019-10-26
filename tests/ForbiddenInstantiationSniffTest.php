<?php declare(strict_types=1);

namespace SfpTest\CodingStandard\Di;

use Sfp\CodingStandard\Di\ForbiddenInstantiationSniff;
use SlevomatCodingStandard\Sniffs\TestCase;

final class ForbiddenInstantiationSniffTest extends TestCase
{
    use SfpSniffClassNameGetterTrait;

    /**
     * @test
     *
     * @dataProvider provideForbiddenInstantiations
     */
    public function check(int $expectedErrorCount, ?int $errorLine, array $sniffProperties) :void
    {
        $filePath = __DIR__ . '/Fixture/ViolateInstantiation.php';

        /** @var \PHP_CodeSniffer\Files\File $file */
        $report = static::checkFile($filePath, $sniffProperties, $codesToCheck = []);

        self::assertSame($expectedErrorCount, $report->getErrorCount());
        if ($errorLine !== null) {
            var_dump($report->getErrors());
            self::assertSniffError($report, $errorLine, ForbiddenInstantiationSniff::VIOLATE_FORBIDDEN_INSTANTIATION_AGAINST_LIST);
        }
    }

    public function provideForbiddenInstantiations() : array
    {
        return [
            'nothing' => [
                'errorCount' => 0,
                'errorLine' => null,
                'sniffProperties' => []
            ],
            'forbiddenPdo' => [
                'errorCount' => 1,
                'errorLine' => 11,
                'sniffProperties' => [
                    'forbiddenFunctions' => [
                        'SfpTest\\DummyPdoFactory' => \PDO::class
                    ]
                ]
            ]
        ];
    }
}