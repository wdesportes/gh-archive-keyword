<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'comment_id',
        'repository_id',
        'body',
    ];

}
