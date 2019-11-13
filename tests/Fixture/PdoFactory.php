<?php


namespace SfpCodingStandardTest\Sniffs\Di\Fixture;


class PdoFactory
{
    public function __invoke() : \PDO
    {
        return new \PDO('dsn', 'username', 'passwd');
    }
}