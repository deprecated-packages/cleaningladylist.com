<?php


namespace CleaningLadyList\Utils\PHPStan\Rule;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;


final class NoGetRepositoryOutsideConstructorRule implements Rule
{
    const GET_REPOSITORY = 'getRepository';
    const REPOSITORY = 'Repository';
    const __CONSTRUCTOR = '__constructor';

    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Don\'t use getRepository() outside the constructor';

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /**
     * @param MethodCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {

        if (!($node->name instanceof Identifier)) {
            return [];
        }

        if ((string)$node->name === self::GET_REPOSITORY && (string)$scope->getFunction()->getName() != self::__CONSTRUCTOR && $this->isRepositoryClass($scope)) {
            return [self::ERROR_MESSAGE];
        }

        return [];
    }

    private function isRepositoryClass(Scope $scope): bool
    {
        $filename = $scope->getClassReflection()->getFileName();
        return str_contains($filename, self::REPOSITORY) ? true : false;
    }

}
