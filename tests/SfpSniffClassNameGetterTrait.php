<?php declare(strict_types=1);

namespace SfpCodingStandardTest\Sniffs\Di;

trait SfpSniffClassNameGetterTrait
{
    /**
     * @psalm-return class-string
     */
    protected static function getSniffClassName(): string
    {
        $className = str_replace('SfpCodingStandardTest', 'SfpCodingStandard', static::class);
        return substr($className, 0, -strlen('Test'));
    }
}