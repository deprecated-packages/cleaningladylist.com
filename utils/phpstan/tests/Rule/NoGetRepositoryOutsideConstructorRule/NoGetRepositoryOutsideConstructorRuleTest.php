<?php

declare(strict_types=1);

namespace CleaningLadyList\Utils\PHPStan\Tests\Rule\NoEntityManagerInControllerRule;

use CleaningLadyList\Utils\PHPStan\Rule\NoGetRepositoryOutsideConstructorRule;
use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

final class NoGetRepositoryOutsideConstructorRuleTest extends RuleTestCase
{
    /**
     * @dataProvider provideData()
     * @param string $filePath
     * @param array $expectedErrorsWithLines
     */
    public function testRule(string $filePath, array $expectedErrorsWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorsWithLines);
    }

    public function provideData(): Iterator
    {
        yield [__DIR__ . '/Fixture/SomeController.php', [[NoGetRepositoryOutsideConstructorRule::ERROR_MESSAGE, 21]]];
    }

    protected function getRule(): Rule
    {
        return new NoGetRepositoryOutsideConstructorRule();
    }
}
