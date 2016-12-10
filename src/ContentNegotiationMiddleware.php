<?php

namespace Against\Psr\Hacks;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Stratigility\MiddlewareInterface;

class ContentNegotiationMiddleware implements MiddlewareInterface
{
    /**
     * Just for demonstration.
     *
     * @see https://tools.ietf.org/html/rfc7231#section-5.3
     *
     * @param string $accept
     *
     * @return string
     */
    private function negotiate($accept)
    {
        if (strpos($accept, 'application/json') !== false) {
            return 'application/json';
        }

        return 'plain/text';
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = NULL) {
        $accept = $request->getHeaderLine('Accept');
        $type = $this->negotiate($accept);
        $response = $response->withHeader('Content-Type', $type);

        return $next($request, $response);
    }
}
