<?php declare(strict_types=1);

namespace SfpCodingStandardTest\Sniffs\Di\Fixture;

class ViolateInstantiation
{
    public function execute() : void
    {
        new \DateTime;
        // pdo
        new \PDO('dsn');

        new Foo;

        new \PHPUnit\Runner\Exception;
    }
}