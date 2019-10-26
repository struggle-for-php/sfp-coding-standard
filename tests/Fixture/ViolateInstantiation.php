<?php declare(strict_types=1);

namespace SfpTest\CodingStandard\Di\Fixture;

class ViolateInstantiation
{
    public function execute() : void
    {
        new \DateTime;
        // pdo
        new \PDO('dsn');

        new \PHPUnit\Runner\Exception;
    }
}