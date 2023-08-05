<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Symfony\Bridge\Twig\Extension;

use Torch202308\Symfony\Component\Stopwatch\Stopwatch;
use Torch202308\Symfony\Component\Stopwatch\StopwatchEvent;
use Torch202308\Twig\Extension\ProfilerExtension as BaseProfilerExtension;
use Torch202308\Twig\Profiler\Profile;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class ProfilerExtension extends BaseProfilerExtension
{
    /**
     * @var \Symfony\Component\Stopwatch\Stopwatch|null
     */
    private $stopwatch;
    /**
     * @var \SplObjectStorage<Profile, StopwatchEvent>
     */
    private $events;
    public function __construct(Profile $profile, Stopwatch $stopwatch = null)
    {
        parent::__construct($profile);
        $this->stopwatch = $stopwatch;
        $this->events = new \SplObjectStorage();
    }
    public function enter(Profile $profile) : void
    {
        if ($this->stopwatch && $profile->isTemplate()) {
            $this->events[$profile] = $this->stopwatch->start($profile->getName(), 'template');
        }
        parent::enter($profile);
    }
    public function leave(Profile $profile) : void
    {
        parent::leave($profile);
        if ($this->stopwatch && $profile->isTemplate()) {
            $this->events[$profile]->stop();
            unset($this->events[$profile]);
        }
    }
}