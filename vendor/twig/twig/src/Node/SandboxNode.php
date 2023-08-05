<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Twig\Node;

use Torch202308\Twig\Compiler;
/**
 * Represents a sandbox node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SandboxNode extends Node
{
    public function __construct(Node $body, int $lineno, string $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this)->write("if (!\$alreadySandboxed = \$this->sandbox->isSandboxed()) {\n")->indent()->write("\$this->sandbox->enableSandbox();\n")->outdent()->write("}\n")->write("try {\n")->indent()->subcompile($this->getNode('body'))->outdent()->write("} finally {\n")->indent()->write("if (!\$alreadySandboxed) {\n")->indent()->write("\$this->sandbox->disableSandbox();\n")->outdent()->write("}\n")->outdent()->write("}\n");
    }
}
\class_alias('Torch202308\\Twig\\Node\\SandboxNode', 'Torch202308\\Twig_Node_Sandbox');