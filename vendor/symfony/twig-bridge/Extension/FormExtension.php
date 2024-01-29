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

use Torch202401\Symfony\Bridge\Twig\Node\RenderBlockNode;
use Torch202401\Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode;
use Torch202401\Symfony\Bridge\Twig\TokenParser\FormThemeTokenParser;
use Torch202401\Symfony\Component\Form\ChoiceList\View\ChoiceGroupView;
use Torch202401\Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Torch202401\Symfony\Component\Form\FormError;
use Torch202401\Symfony\Component\Form\FormRenderer;
use Torch202401\Symfony\Component\Form\FormView;
use Torch202401\Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Torch202401\Twig\TwigFilter;
use Torch202401\Twig\TwigFunction;
use Torch202401\Twig\TwigTest;
/**
 * FormExtension extends Twig with form capabilities.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
final class FormExtension extends AbstractExtension
{
    /**
     * @var \Symfony\Contracts\Translation\TranslatorInterface|null
     */
    private $translator;
    public function __construct(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }
    public function getTokenParsers() : array
    {
        return [
            // {% form_theme form "SomeBundle::widgets.twig" %}
            new FormThemeTokenParser(),
        ];
    }
    public function getFunctions() : array
    {
        return [new TwigFunction('form_widget', null, ['node_class' => SearchAndRenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('form_errors', null, ['node_class' => SearchAndRenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('form_label', null, ['node_class' => SearchAndRenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('form_help', null, ['node_class' => SearchAndRenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('form_row', null, ['node_class' => SearchAndRenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('form_rest', null, ['node_class' => SearchAndRenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('form', null, ['node_class' => RenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('form_start', null, ['node_class' => RenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('form_end', null, ['node_class' => RenderBlockNode::class, 'is_safe' => ['html']]), new TwigFunction('csrf_token', [FormRenderer::class, 'renderCsrfToken']), new TwigFunction('form_parent', 'Torch202401\\Symfony\\Bridge\\Twig\\Extension\\twig_get_form_parent'), new TwigFunction('field_name', \Closure::fromCallable([$this, 'getFieldName'])), new TwigFunction('field_value', \Closure::fromCallable([$this, 'getFieldValue'])), new TwigFunction('field_label', \Closure::fromCallable([$this, 'getFieldLabel'])), new TwigFunction('field_help', \Closure::fromCallable([$this, 'getFieldHelp'])), new TwigFunction('field_errors', \Closure::fromCallable([$this, 'getFieldErrors'])), new TwigFunction('field_choices', \Closure::fromCallable([$this, 'getFieldChoices']))];
    }
    public function getFilters() : array
    {
        return [new TwigFilter('humanize', [FormRenderer::class, 'humanize']), new TwigFilter('form_encode_currency', [FormRenderer::class, 'encodeCurrency'], ['is_safe' => ['html'], 'needs_environment' => \true])];
    }
    public function getTests() : array
    {
        return [new TwigTest('selectedchoice', 'Torch202401\\Symfony\\Bridge\\Twig\\Extension\\twig_is_selected_choice'), new TwigTest('rootform', 'Torch202401\\Symfony\\Bridge\\Twig\\Extension\\twig_is_root_form')];
    }
    public function getFieldName(FormView $view) : string
    {
        $view->setRendered();
        return $view->vars['full_name'];
    }
    /**
     * @return string|mixed[]
     */
    public function getFieldValue(FormView $view)
    {
        return $view->vars['value'];
    }
    public function getFieldLabel(FormView $view) : ?string
    {
        if (\false === ($label = $view->vars['label'])) {
            return null;
        }
        if (!$label && ($labelFormat = $view->vars['label_format'])) {
            $label = \str_replace(['%id%', '%name%'], [$view->vars['id'], $view->vars['name']], $labelFormat);
        } elseif (!$label) {
            $label = \ucfirst(\strtolower(\trim(\preg_replace(['/([A-Z])/', '/[_\\s]+/'], ['_$1', ' '], $view->vars['name']))));
        }
        return $this->createFieldTranslation($label, $view->vars['label_translation_parameters'] ?: [], $view->vars['translation_domain']);
    }
    public function getFieldHelp(FormView $view) : ?string
    {
        return $this->createFieldTranslation($view->vars['help'], $view->vars['help_translation_parameters'] ?: [], $view->vars['translation_domain']);
    }
    /**
     * @return string[]
     */
    public function getFieldErrors(FormView $view) : iterable
    {
        /** @var FormError $error */
        foreach ($view->vars['errors'] as $error) {
            (yield $error->getMessage());
        }
    }
    /**
     * @return string[]|string[][]
     */
    public function getFieldChoices(FormView $view) : iterable
    {
        yield from $this->createFieldChoicesList($view->vars['choices'], $view->vars['choice_translation_domain']);
    }
    /**
     * @param string|false|null $translationDomain
     */
    private function createFieldChoicesList(iterable $choices, $translationDomain) : iterable
    {
        foreach ($choices as $choice) {
            $translatableLabel = $this->createFieldTranslation($choice->label, [], $translationDomain);
            if ($choice instanceof ChoiceGroupView) {
                (yield $translatableLabel => $this->createFieldChoicesList($choice, $translationDomain));
                continue;
            }
            /* @var ChoiceView $choice */
            (yield $translatableLabel => $choice->value);
        }
    }
    /**
     * @param string|false|null $domain
     */
    private function createFieldTranslation(?string $value, array $parameters, $domain) : ?string
    {
        if (!$this->translator || !$value || \false === $domain) {
            return $value;
        }
        return $this->translator->trans($value, $parameters, $domain);
    }
}
/**
 * Returns whether a choice is selected for a given form value.
 *
 * This is a function and not callable due to performance reasons.
 *
 * @see ChoiceView::isSelected()
 * @param string|mixed[]|null $selectedValue
 */
function twig_is_selected_choice(ChoiceView $choice, $selectedValue) : bool
{
    if (\is_array($selectedValue)) {
        return \in_array($choice->value, $selectedValue, \true);
    }
    return $choice->value === $selectedValue;
}
/**
 * @internal
 */
function twig_is_root_form(FormView $formView) : bool
{
    return null === $formView->parent;
}
/**
 * @internal
 */
function twig_get_form_parent(FormView $formView) : ?FormView
{
    return $formView->parent;
}
