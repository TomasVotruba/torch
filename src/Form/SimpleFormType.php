<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Dummy simple form to fake form object for rendering.
 */
final class SimpleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options): void
    {
        $formBuilder->add('name', TextType::class);
    }
}
