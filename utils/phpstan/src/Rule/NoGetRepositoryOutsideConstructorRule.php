<?php


namespace App\PHPStan\Rule;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\TypeWithClassName;


final class NoGetRepositoryOutsideConstructorRule implements Rule
{

    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Use getRepository() inside constructor';


    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ((string) $node->name !== '__construct') {
            return [];
        }
        return [];
    }
}
