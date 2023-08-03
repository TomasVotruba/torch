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

use Torch202308\Twig\Profiler\NodeVisitor\ProfilerNodeVisitor;
use Torch202308\Twig\Profiler\Profile;
class ProfilerExtension extends AbstractExtension
{
    private $actives = [];
    public function __construct(Profile $profile)
    {
        $this->actives[] = $profile;
    }
    public function enter(Profile $profile)
    {
        $this->actives[0]->addProfile($profile);
        \array_unshift($this->actives, $profile);
    }
    public function leave(Profile $profile)
    {
        $profile->leave();
        \array_shift($this->actives);
        if (1 === \count($this->actives)) {
            $this->actives[0]->leave();
        }
    }
    public function getNodeVisitors()
    {
        return [new ProfilerNodeVisitor(static::class)];
    }
}
\class_alias('Torch202308\\Twig\\Extension\\ProfilerExtension', 'Torch202308\\Twig_Extension_Profiler');
