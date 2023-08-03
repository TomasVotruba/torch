<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Twig\Extension;

use Torch202308\Twig\NodeVisitor\OptimizerNodeVisitor;
final class OptimizerExtension extends AbstractExtension
{
    private $optimizers;
    public function __construct($optimizers = -1)
    {
        $this->optimizers = $optimizers;
    }
    public function getNodeVisitors()
    {
        return [new OptimizerNodeVisitor($this->optimizers)];
    }
}
\class_alias('Torch202308\\Twig\\Extension\\OptimizerExtension', 'Torch202308\\Twig_Extension_Optimizer');
