<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class AppExtension extends AbstractExtension
{

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('page', [$this, 'showPageNumber']),
        ];
    }

    /**
     * @param  int  $number
     *
     * @return string
     */
    public function showPageNumber(int $number = 1): string
    {
        return ($number > 1) ? ' - ' . $this->translator->trans('text.page') . ' ' . $number : '';
    }

}
