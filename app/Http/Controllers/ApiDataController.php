<?php

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Models\IssueComment;
use App\Models\PullRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiDataController extends AbstractController
{

    /**
     * Get search page
     * @return mixed Actually a Illuminate\View\View but phpstan does not agree
     */
    public function getSearchIndex(Request $request)
    {
        if ($request->query->has('searchTerm')) {
            $searchDate = Carbon::createFromFormat('!Y-m-d', $request->query->get('searchDate'));
            $searchTerm = $request->query->get('searchTerm');
            $searchTermSql = '%' . $searchTerm . '%';
            $commits = Commit::with('repository')->forDate($searchDate)->forTerm($searchTermSql);
            $commitCount = $commits->count();
            $issueCount = IssueComment::forDate($searchDate)->forTerm($searchTermSql)->count();
            $pullsCount = PullRequest::forDate($searchDate)->forTerm($searchTermSql)->count();
            return View::make('index', [
                'eventCount' => $commitCount + $issueCount + $pullsCount,
                'dateString' => $searchDate->format('d m Y'),
                'searchDate' => $searchDate->format('Y-m-d'),
                'searchTerm' => $searchTerm,
                'commits' => $commits->limit(1000)->get(),
                'commitsPoints' => [],
                'pullsPoints' => [],
                'commentsPoints' => [],
                'commitCount' => $commitCount,
                'commentCount' => $issueCount,
                'pullsCount' => $pullsCount,
            ]);
        }
        return View::make('index', [
            'searchDate' => $this->getSuggestedDate(),
            'commitCount' => Commit::count(),
            'commentCount' => IssueComment::count(),
            'pullsCount' => PullRequest::count(),
        ]);
    }

    private function getSuggestedDate(): string
    {
        $firstCommit = Commit::first();
        if ($firstCommit === null) {
            return Carbon::now()->format('Y-m-d');
        }
        return $firstCommit->{'created_at'}->format('Y-m-d');
    }
}
