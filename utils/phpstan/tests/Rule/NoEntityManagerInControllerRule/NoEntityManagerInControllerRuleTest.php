<?php

declare(strict_types=1);

namespace CleaningLadyList\Utils\PHPStan\Tests\Rule\NoEntityManagerInControllerRule;

use CleaningLadyList\Utils\PHPStan\Rule\NoEntityManagerInControllerRule;
use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

final class NoEntityManagerInControllerRuleTest extends RuleTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function testRule(string $filePath, array $expectedErrorsWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorsWithLines);
    }

    public function provideData(): Iterator
    {
        yield [__DIR__ . '/Fixture/UsingEntityManagerController.php', [[NoEntityManagerInControllerRule::ERROR_MESSAGE, 14]]];
    }

    protected function getRule(): Rule
    {
        return new NoEntityManagerInControllerRule();
    }
}
