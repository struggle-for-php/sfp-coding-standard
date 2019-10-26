<?php declare(strict_types=1);

namespace SfpTest\CodingStandard\Di;

trait SfpSniffClassNameGetterTrait
{
    /**
     * @psalm-return class-string
     */
    protected static function getSniffClassName(): string
    {
        $className = str_replace('SfpTest', 'Sfp', static::class);
        return substr($className, 0, -strlen('Test'));
    }
}