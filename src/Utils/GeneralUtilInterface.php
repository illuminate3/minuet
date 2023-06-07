<?php

declare(strict_types=1);

namespace App\Utils;

interface GeneralUtilInterface
{
    public static function getBearerToken($cache, $carClientApi);

    public static function callBearerToken($carClientApi);
}
