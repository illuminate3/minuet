<?php

declare(strict_types=1);

namespace App\Utils;

interface SluggerInterface
{

    /**
     * @param  string  $string
     *
     * @return string
     */
    public static function slugify(string $string): string;

}
