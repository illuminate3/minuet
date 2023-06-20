<?php

declare(strict_types=1);

namespace App\Utils;

interface GeneralUtilInterface
{

    /**
     * @param $cache
     * @param $carClientApi
     *
     * @return mixed
     */
    public static function getBearerToken($cache, $carClientApi): mixed;

    /**
     * @param $carClientApi
     *
     * @return mixed
     */
    public static function callBearerToken($carClientApi): mixed;

}
