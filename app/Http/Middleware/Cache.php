<?php

namespace App\Http\Middleware;

use \App\Utils\Cache\File as CacheFile;

class Cache
{
    private function isCacheable($request) {
        if (CACHE_TIME <= 0) {
            return false;
        }

        if ($request->getHttpMethod() != 'GET') {
            return false;
        }

        $headers = $request->getHeaders();
        if (isset($headers['Cache-Control']) && $headers['Cache-Control'] == 'no-cache') {
            return false;
        }

        return true;    
    }

    private function getHash($request) {
        $uri = $request->getRouter()->getUri();
        $queryParams = $request->getQueryParams();
        $uri .= !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
        
        return rtrim('route-' . preg_replace('/[^0-9a-zA-Z]/', '-', ltrim($uri, '/')), '-');
    }

    public function handle($request, $next) {
        if (!$this->isCacheable($request)) return $next($request);

        $hash = $this->getHash($request);
        
        return CacheFile::getCache($hash, CACHE_TIME, function () use ($request, $next) {
            return $next($request);
        });
    }
}