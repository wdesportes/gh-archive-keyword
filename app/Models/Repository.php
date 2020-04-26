<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Repository extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repositories';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'slug',
    ];

}
