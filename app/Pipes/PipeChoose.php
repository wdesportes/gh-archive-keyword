<?php

namespace App\Pipes;

use Closure;
use stdClass;

final class PipeChoose
{
    /**
     * Choose to drop or pass the data to the next pipe
     * @return int The event Id
     */
    public function handle(?stdClass $data, Closure $next): int
    {
        if ($data === null) {
            return -1;
        }

        $goodEvents = [
            'PushEvent',
            'IssueCommentEvent',
            'PullRequestEvent',
        ];
        if (in_array($data->type, $goodEvents)) {
            if ($data->type === 'PullRequestEvent' && $data->payload->action !== 'opened') {
                // Skip non pull-request open events
                return $data->id;
            }
            return $next($data);
        }
        return $data->id;
    }
}
