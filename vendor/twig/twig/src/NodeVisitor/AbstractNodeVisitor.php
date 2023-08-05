<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Twig\NodeVisitor;

use Twig\Environment;
use Torch202308\Twig\Node\Node;
/**
 * Used to make node visitors compatible with Twig 1.x and 2.x.
 *
 * To be removed in Twig 3.1.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractNodeVisitor implements NodeVisitorInterface
{
    public final function enterNode(Node $node, Environment $env)
    {
        return $this->doEnterNode($node, $env);
    }
    public final function leaveNode(Node $node, Environment $env)
    {
        return $this->doLeaveNode($node, $env);
    }
    /**
     * Called before child nodes are visited.
     *
     * @return Node The modified node
     */
    protected abstract function doEnterNode(Node $node, Environment $env);
    /**
     * Called after child nodes are visited.
     *
     * @return Node|null The modified node or null if the node must be removed
     */
    protected abstract function doLeaveNode(Node $node, Environment $env);
}
\class_alias('Torch202308\\Twig\\NodeVisitor\\AbstractNodeVisitor', 'Torch202308\\Twig_BaseNodeVisitor');
