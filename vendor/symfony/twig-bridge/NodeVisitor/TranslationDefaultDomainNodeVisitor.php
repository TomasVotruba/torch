<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Symfony\Bridge\Twig\NodeVisitor;

use Torch202401\Symfony\Bridge\Twig\Node\TransDefaultDomainNode;
use Torch202401\Symfony\Bridge\Twig\Node\TransNode;
use Twig\Environment;
use Torch202401\Twig\Node\BlockNode;
use Torch202401\Twig\Node\Expression\ArrayExpression;
use Torch202401\Twig\Node\Expression\AssignNameExpression;
use Torch202401\Twig\Node\Expression\ConstantExpression;
use Torch202401\Twig\Node\Expression\FilterExpression;
use Torch202401\Twig\Node\Expression\NameExpression;
use Torch202401\Twig\Node\ModuleNode;
use Torch202401\Twig\Node\Node;
use Torch202401\Twig\Node\SetNode;
use Torch202401\Twig\NodeVisitor\AbstractNodeVisitor;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class TranslationDefaultDomainNodeVisitor extends AbstractNodeVisitor
{
    /**
     * @var \Symfony\Bridge\Twig\NodeVisitor\Scope
     */
    private $scope;
    public function __construct()
    {
        $this->scope = new Scope();
    }
    protected function doEnterNode(Node $node, Environment $env) : Node
    {
        if ($node instanceof BlockNode || $node instanceof ModuleNode) {
            $this->scope = $this->scope->enter();
        }
        if ($node instanceof TransDefaultDomainNode) {
            if ($node->getNode('expr') instanceof ConstantExpression) {
                $this->scope->set('domain', $node->getNode('expr'));
                return $node;
            } else {
                $var = $this->getVarName();
                $name = new AssignNameExpression($var, $node->getTemplateLine());
                $this->scope->set('domain', new NameExpression($var, $node->getTemplateLine()));
                return new SetNode(\false, new Node([$name]), new Node([$node->getNode('expr')]), $node->getTemplateLine());
            }
        }
        if (!$this->scope->has('domain')) {
            return $node;
        }
        if ($node instanceof FilterExpression && 'trans' === $node->getNode('filter')->getAttribute('value')) {
            $arguments = $node->getNode('arguments');
            if ($this->isNamedArguments($arguments)) {
                if (!$arguments->hasNode('domain') && !$arguments->hasNode(1)) {
                    $arguments->setNode('domain', $this->scope->get('domain'));
                }
            } elseif (!$arguments->hasNode(1)) {
                if (!$arguments->hasNode(0)) {
                    $arguments->setNode(0, new ArrayExpression([], $node->getTemplateLine()));
                }
                $arguments->setNode(1, $this->scope->get('domain'));
            }
        } elseif ($node instanceof TransNode) {
            if (!$node->hasNode('domain')) {
                $node->setNode('domain', $this->scope->get('domain'));
            }
        }
        return $node;
    }
    protected function doLeaveNode(Node $node, Environment $env) : ?Node
    {
        if ($node instanceof TransDefaultDomainNode) {
            return null;
        }
        if ($node instanceof BlockNode || $node instanceof ModuleNode) {
            $this->scope = $this->scope->leave();
        }
        return $node;
    }
    public function getPriority() : int
    {
        return -10;
    }
    private function isNamedArguments(Node $arguments) : bool
    {
        foreach ($arguments as $name => $node) {
            if (!\is_int($name)) {
                return \true;
            }
        }
        return \false;
    }
    private function getVarName() : string
    {
        return \sprintf('__internal_%s', \hash('sha256', \uniqid(\mt_rand(), \true), \false));
    }
}
