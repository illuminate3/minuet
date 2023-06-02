<?php

declare(strict_types=1);

namespace App\Utils;
use Symfony\Component\HttpFoundation\Request;

interface GeneralUtilInterface
{
    public static function CURLCallCARAPI($endPoint, Request $request, $data, $method = 'GET');

    public static function CurlCallLoginApi($endPoint, Request $request, $data, $method = 'GET');
}
