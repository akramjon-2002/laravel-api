<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RejectMalformedJson
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isJson()) {
            $content = trim($request->getContent());

            if ($content !== '') {
                json_decode($content, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new BadRequestHttpException('Malformed JSON payload.');
                }
            }
        }

        return $next($request);
    }
}
