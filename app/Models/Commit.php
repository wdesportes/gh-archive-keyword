<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
