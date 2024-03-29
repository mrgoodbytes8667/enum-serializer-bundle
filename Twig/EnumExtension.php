<?php


namespace Bytes\EnumSerializerBundle\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EnumExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('enum_label', [EnumRuntime::class, 'getFormLabel']),
        ];
    }
}
