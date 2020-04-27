<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

final class IssueComment extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'issue_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'created_at',
        'comment_id',
        'repository_id',
        'body',
    ];

    public function scopeForDate(Builder $query, Carbon $date): Builder
    {
        $query->whereDate('created_at', $date->format('Y-m-d'));
        return $query;
    }

    public function scopeForTerm(Builder $query, string $searchTerm): Builder
    {
        $query->where('body', 'LIKE', $searchTerm);
        return $query;
    }
}
