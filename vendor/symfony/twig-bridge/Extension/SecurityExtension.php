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

use Torch202401\Symfony\Component\Security\Acl\Voter\FieldVote;
use Torch202401\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Torch202401\Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Torch202401\Symfony\Component\Security\Http\Impersonate\ImpersonateUrlGenerator;
use Twig\Extension\AbstractExtension;
use Torch202401\Twig\TwigFunction;
/**
 * SecurityExtension exposes security context features.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class SecurityExtension extends AbstractExtension
{
    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface|null
     */
    private $securityChecker;
    /**
     * @var \Symfony\Component\Security\Http\Impersonate\ImpersonateUrlGenerator|null
     */
    private $impersonateUrlGenerator;
    public function __construct(AuthorizationCheckerInterface $securityChecker = null, ImpersonateUrlGenerator $impersonateUrlGenerator = null)
    {
        $this->securityChecker = $securityChecker;
        $this->impersonateUrlGenerator = $impersonateUrlGenerator;
    }
    /**
     * @param mixed $role
     * @param mixed $object
     */
    public function isGranted($role, $object = null, string $field = null) : bool
    {
        if (null === $this->securityChecker) {
            return \false;
        }
        if (null !== $field) {
            $object = new FieldVote($object, $field);
        }
        try {
            return $this->securityChecker->isGranted($role, $object);
        } catch (AuthenticationCredentialsNotFoundException $exception) {
            return \false;
        }
    }
    public function getImpersonateExitUrl(string $exitTo = null) : string
    {
        if (null === $this->impersonateUrlGenerator) {
            return '';
        }
        return $this->impersonateUrlGenerator->generateExitUrl($exitTo);
    }
    public function getImpersonateExitPath(string $exitTo = null) : string
    {
        if (null === $this->impersonateUrlGenerator) {
            return '';
        }
        return $this->impersonateUrlGenerator->generateExitPath($exitTo);
    }
    public function getImpersonateUrl(string $identifier) : string
    {
        if (null === $this->impersonateUrlGenerator) {
            return '';
        }
        return $this->impersonateUrlGenerator->generateImpersonationUrl($identifier);
    }
    public function getImpersonatePath(string $identifier) : string
    {
        if (null === $this->impersonateUrlGenerator) {
            return '';
        }
        return $this->impersonateUrlGenerator->generateImpersonationPath($identifier);
    }
    public function getFunctions() : array
    {
        return [new TwigFunction('is_granted', \Closure::fromCallable([$this, 'isGranted'])), new TwigFunction('impersonation_exit_url', \Closure::fromCallable([$this, 'getImpersonateExitUrl'])), new TwigFunction('impersonation_exit_path', \Closure::fromCallable([$this, 'getImpersonateExitPath'])), new TwigFunction('impersonation_url', \Closure::fromCallable([$this, 'getImpersonateUrl'])), new TwigFunction('impersonation_path', \Closure::fromCallable([$this, 'getImpersonatePath']))];
    }
}
