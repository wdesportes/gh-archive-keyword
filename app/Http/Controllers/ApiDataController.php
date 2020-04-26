<?php

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Models\IssueComment;
use App\Models\PullRequest;
use Illuminate\Support\Facades\View;

class ApiDataController extends AbstractController
{

    /**
     * Get search page
     * @return mixed Actually a Illuminate\View\View but phpstan does not agree
     */
    public function getSearchIndex()
    {
        return View::make('index', [
            'commitCount' => Commit::count(),
            'commentCount' => IssueComment::count(),
            'pullsCount' => PullRequest::count(),
        ]);
    }
}
