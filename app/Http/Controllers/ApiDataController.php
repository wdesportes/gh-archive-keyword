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
                'commitsPoints' => $this->getCommitsCountByHourForTermAndDate($searchTermSql, $searchDate),
                'pullsPoints' => $this->getPullCountByHourForTermAndDate($searchTermSql, $searchDate),
                'commentsPoints' => $this->getIssueCommentCountByHourForTermAndDate($searchTermSql, $searchDate),
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
        $firstCommit = Commit::orderBy('created_at', 'DESC')->first();
        if ($firstCommit === null) {
            return Carbon::now()->format('Y-m-d');
        }
        return $firstCommit->{'created_at'}->format('Y-m-d');
    }

    /**
     * Get the number of commits mentionning a term
     *
     * @param string $searchTermSql The search term in a SQL format using the joker token
     * @param Carbon $searchDate The search date
     * @return array<int,int>
     */
    private function getCommitsCountByHourForTermAndDate(string $searchTermSql, Carbon $searchDate): array
    {
        $commits = Commit::select([])->forDate($searchDate)->forTerm($searchTermSql);
        $commits->selectRaw('COUNT(*) as number');
        $commits->selectRaw('HOUR(created_at) as hour');
        $commits->groupByRaw('HOUR(created_at)');
        $commitsData = $commits->get();
        $hourData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourData[$i] = $commitsData->where('hour', $i)->first()->{'number'} ?? 0;
        }
        return $hourData;
    }

    /**
     * Get the number of issues mentionning a term
     *
     * @param string $searchTermSql The search term in a SQL format using the joker token
     * @param Carbon $searchDate The search date
     * @return array<int,int>
     */
    private function getIssueCommentCountByHourForTermAndDate(string $searchTermSql, Carbon $searchDate): array
    {
        $comments = IssueComment::select([])->forDate($searchDate)->forTerm($searchTermSql);
        $comments->selectRaw('COUNT(*) as number');
        $comments->selectRaw('HOUR(created_at) as hour');
        $comments->groupByRaw('HOUR(created_at)');
        $commentsData = $comments->get();
        $hourData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourData[$i] = $commentsData->where('hour', $i)->first()->{'number'} ?? 0;
        }
        return $hourData;
    }

    /**
     * Get the number of pull requests mentionning a term
     *
     * @param string $searchTermSql The search term in a SQL format using the joker token
     * @param Carbon $searchDate The search date
     * @return array<int,int>
     */
    private function getPullCountByHourForTermAndDate(string $searchTermSql, Carbon $searchDate): array
    {
        $pullRequests = PullRequest::select([])->forDate($searchDate)->forTerm($searchTermSql);
        $pullRequests->selectRaw('COUNT(*) as number');
        $pullRequests->selectRaw('HOUR(created_at) as hour');
        $pullRequests->groupByRaw('HOUR(created_at)');
        $pullRequestsData = $pullRequests->get();
        $hourData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourData[$i] = $pullRequestsData->where('hour', $i)->first()->{'number'} ?? 0;
        }
        return $hourData;
    }
}
