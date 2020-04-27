<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

final class PullRequest extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pull_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'pull_id',
        'repository_id',
        'title',
        'body',
    ];

    public function scopeForDate(Builder $query, Carbon $date): Builder
    {
        $query->whereDate('created_at', $date->format('Y-m-d'));
        return $query;
    }

    public function scopeForTerm(Builder $query, string $searchTerm): Builder
    {
        $query->where('title', 'LIKE', $searchTerm);
        $query->orWhere('body', 'LIKE', $searchTerm);
        return $query;
    }
}
