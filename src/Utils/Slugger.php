<?php

declare(strict_types=1);


namespace App\Utils;

use Symfony\Component\String\Slugger\AsciiSlugger;
use voku\helper\ASCII;

use function function_exists;

final class Slugger implements SluggerInterface
{

    /**
     * @param  string  $string
     *
     * @return string
     */
    public static function slugify(string $string): string
    {
        if (!function_exists('transliterate_transliterate')) {
            $string = self::ascii($string);
        }

        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($string)->lower();

        return (string) $slug;
    }

    /**
     * @param $value
     *
     * @return string
     */
    private static function ascii($value): string
    {
        $language = 'en';
        return ASCII::to_ascii((string) $value, $language);
    }

}
