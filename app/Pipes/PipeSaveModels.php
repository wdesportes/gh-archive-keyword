<?php

namespace App\Pipes;

use App\Models\Commit;
use App\Models\IssueComment;
use App\Models\PullRequest;
use App\Models\Repository;
use Closure;
use stdClass;
use Illuminate\Support\Facades\Cache;

final class PipeSaveModels
{
    /**
     * Save the models
     * @return int The event Id
     */
    public function handle(stdClass $data, Closure $next): int
    {
        if (Cache::missing('repository_' . $data->repo->id)) {
            Repository::firstOrCreate([
                'id' => $data->repo->id,
                'slug' => $data->repo->name,
            ]);
            Cache::put('repository_' . $data->repo->id, true);
        }
        switch ($data->type) {
            case 'PushEvent':
                foreach ($data->payload->commits as $commit) {
                    Commit::create([
                        'push_id' => $data->payload->push_id,
                        'repository_id' => $data->repo->id,
                        'sha' => $commit->sha,
                        'message' => $commit->message,
                    ]);
                }
                break;
            case 'IssueCommentEvent':
                IssueComment::create([
                    'comment_id' => $data->payload->comment->id,
                    'repository_id' => $data->repo->id,
                    'body' => $data->payload->comment->body,
                ]);
                break;
            case 'PullRequestEvent':
                PullRequest::create([
                    'pull_id' => $data->payload->pull_request->id,
                    'repository_id' => $data->repo->id,
                    'title' => $data->payload->pull_request->title,
                    'body' => $data->payload->pull_request->body ?? '',
                ]);
                break;
        }
        return $data->id;
    }
}
