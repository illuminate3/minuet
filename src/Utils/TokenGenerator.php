<?php

declare(strict_types=1);

namespace App\Utils;

use Exception;

final class TokenGenerator
{
    /**
     * @throws Exception
     */
    public function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
