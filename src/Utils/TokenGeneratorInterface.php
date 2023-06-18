<?php

declare(strict_types=1);

namespace App\Utils;

interface TokenGeneratorInterface
{

    /**
     * @return string
     */
    public function generateToken(): string;

}
