<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Symfony\Bridge\Twig\Extension;

use Torch202401\Symfony\Component\Workflow\Registry;
use Torch202401\Symfony\Component\Workflow\Transition;
use Torch202401\Symfony\Component\Workflow\TransitionBlockerList;
use Torch202401\Twig\Extension\AbstractExtension;
use Torch202401\Twig\TwigFunction;
/**
 * WorkflowExtension.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 * @author Carlos Pereira De Amorim <carlos@shauri.fr>
 */
final class WorkflowExtension extends AbstractExtension
{
    /**
     * @var \Symfony\Component\Workflow\Registry
     */
    private $workflowRegistry;
    public function __construct(Registry $workflowRegistry)
    {
        $this->workflowRegistry = $workflowRegistry;
    }
    public function getFunctions() : array
    {
        return [new TwigFunction('workflow_can', \Closure::fromCallable([$this, 'canTransition'])), new TwigFunction('workflow_transitions', \Closure::fromCallable([$this, 'getEnabledTransitions'])), new TwigFunction('workflow_transition', \Closure::fromCallable([$this, 'getEnabledTransition'])), new TwigFunction('workflow_has_marked_place', \Closure::fromCallable([$this, 'hasMarkedPlace'])), new TwigFunction('workflow_marked_places', \Closure::fromCallable([$this, 'getMarkedPlaces'])), new TwigFunction('workflow_metadata', \Closure::fromCallable([$this, 'getMetadata'])), new TwigFunction('workflow_transition_blockers', \Closure::fromCallable([$this, 'buildTransitionBlockerList']))];
    }
    /**
     * Returns true if the transition is enabled.
     */
    public function canTransition(object $subject, string $transitionName, string $name = null) : bool
    {
        return $this->workflowRegistry->get($subject, $name)->can($subject, $transitionName);
    }
    /**
     * Returns all enabled transitions.
     *
     * @return Transition[]
     */
    public function getEnabledTransitions(object $subject, string $name = null) : array
    {
        return $this->workflowRegistry->get($subject, $name)->getEnabledTransitions($subject);
    }
    public function getEnabledTransition(object $subject, string $transition, string $name = null) : ?Transition
    {
        return $this->workflowRegistry->get($subject, $name)->getEnabledTransition($subject, $transition);
    }
    /**
     * Returns true if the place is marked.
     */
    public function hasMarkedPlace(object $subject, string $placeName, string $name = null) : bool
    {
        return $this->workflowRegistry->get($subject, $name)->getMarking($subject)->has($placeName);
    }
    /**
     * Returns marked places.
     *
     * @return string[]|int[]
     */
    public function getMarkedPlaces(object $subject, bool $placesNameOnly = \true, string $name = null) : array
    {
        $places = $this->workflowRegistry->get($subject, $name)->getMarking($subject)->getPlaces();
        if ($placesNameOnly) {
            return \array_keys($places);
        }
        return $places;
    }
    /**
     * Returns the metadata for a specific subject.
     *
     * @param string|Transition|null $metadataSubject Use null to get workflow metadata
     *                                                Use a string (the place name) to get place metadata
     *                                                Use a Transition instance to get transition metadata
     * @return mixed
     */
    public function getMetadata(object $subject, string $key, $metadataSubject = null, string $name = null)
    {
        return $this->workflowRegistry->get($subject, $name)->getMetadataStore()->getMetadata($key, $metadataSubject);
    }
    public function buildTransitionBlockerList(object $subject, string $transitionName, string $name = null) : TransitionBlockerList
    {
        $workflow = $this->workflowRegistry->get($subject, $name);
        return $workflow->buildTransitionBlockerList($subject, $transitionName);
    }
}
