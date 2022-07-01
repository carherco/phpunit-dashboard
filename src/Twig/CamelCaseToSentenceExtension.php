<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CamelCaseToSentenceExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('camelCase2spaces', [$this, 'convertCamelCaseToHaveSpacesFilter']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('camelCase2spaces', [$this, 'convertCamelCaseToHaveSpacesFilter']),
        ];
    }

    /*
     * Converts camel case string to have spaces
     */
    public function convertCamelCaseToHaveSpacesFilter(string $camelCaseString): string
    {
        $pattern = '/([A-Z])/';
        return preg_replace_callback(
            $pattern,
            function ($matches) {return " " .$matches[0];},
            $camelCaseString
        );
    }
}
