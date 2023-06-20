<?php

declare(strict_types=1);

namespace App\Transformer;

use Symfony\Component\HttpFoundation\Request;

final class RequestToArrayTransformer
{

    /**
     * @param  Request  $request
     *
     * @return array
     */
    public function transform(Request $request): array
    {
        $params = [];
        $params['page'] = $request->query->getInt('page', 1);

        return $params;
    }

}
