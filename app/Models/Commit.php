<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

final class Commit extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commits';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'push_id',
        'repository_id',
        'sha',
        'message',
    ];

    public function repository(): HasOne
    {
        return $this->hasOne(Repository::class, 'id', 'repository_id');
    }

    public function scopeForDate(Builder $query, Carbon $date): Builder
    {
        $query->whereDate('created_at', $date->format('Y-m-d'));
        return $query;
    }

    public function scopeForTerm(Builder $query, string $searchTerm): Builder
    {
        $query->where('message', 'LIKE', $searchTerm);
        return $query;
    }
}
