<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Twig\Profiler\NodeVisitor;

use Twig\Environment;
use Torch202401\Twig\Node\BlockNode;
use Torch202401\Twig\Node\BodyNode;
use Torch202401\Twig\Node\MacroNode;
use Torch202401\Twig\Node\ModuleNode;
use Torch202401\Twig\Node\Node;
use Torch202401\Twig\NodeVisitor\AbstractNodeVisitor;
use Torch202401\Twig\Profiler\Node\EnterProfileNode;
use Torch202401\Twig\Profiler\Node\LeaveProfileNode;
use Torch202401\Twig\Profiler\Profile;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class ProfilerNodeVisitor extends AbstractNodeVisitor
{
    private $extensionName;
    private $varName;
    public function __construct(string $extensionName)
    {
        $this->extensionName = $extensionName;
        $this->varName = \sprintf('__internal_%s', \hash(\PHP_VERSION_ID < 80100 ? 'sha256' : 'xxh128', $extensionName));
    }
    protected function doEnterNode(Node $node, Environment $env)
    {
        return $node;
    }
    protected function doLeaveNode(Node $node, Environment $env)
    {
        if ($node instanceof ModuleNode) {
            $node->setNode('display_start', new Node([new EnterProfileNode($this->extensionName, Profile::TEMPLATE, $node->getTemplateName(), $this->varName), $node->getNode('display_start')]));
            $node->setNode('display_end', new Node([new LeaveProfileNode($this->varName), $node->getNode('display_end')]));
        } elseif ($node instanceof BlockNode) {
            $node->setNode('body', new BodyNode([new EnterProfileNode($this->extensionName, Profile::BLOCK, $node->getAttribute('name'), $this->varName), $node->getNode('body'), new LeaveProfileNode($this->varName)]));
        } elseif ($node instanceof MacroNode) {
            $node->setNode('body', new BodyNode([new EnterProfileNode($this->extensionName, Profile::MACRO, $node->getAttribute('name'), $this->varName), $node->getNode('body'), new LeaveProfileNode($this->varName)]));
        }
        return $node;
    }
    public function getPriority()
    {
        return 0;
    }
}
\class_alias('Torch202401\\Twig\\Profiler\\NodeVisitor\\ProfilerNodeVisitor', 'Torch202401\\Twig_Profiler_NodeVisitor_Profiler');
