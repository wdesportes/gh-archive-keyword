<?php

namespace App\Pipes;

use Closure;

final class PipeDecode
{
    /**
     * JSON decode the data
     * @return mixed The next pipe
     */
    public function handle(string $data, Closure $next)
    {
        $data = json_decode($data);
        return $next($data);
    }
}
