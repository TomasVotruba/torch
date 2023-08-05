<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\Form;

use Torch202308\Symfony\Component\Form\AbstractType;
use Torch202308\Symfony\Component\Form\Extension\Core\Type\TextType;
use Torch202308\Symfony\Component\Form\FormBuilderInterface;
/**
 * Dummy simple form to fake form object for rendering.
 */
final class SimpleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options) : void
    {
        $formBuilder->add('name', TextType::class);
    }
}
