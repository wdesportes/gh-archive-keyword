<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
