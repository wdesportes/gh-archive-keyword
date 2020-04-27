<?php

use App\Http\Controllers\ApiDataController;
use Illuminate\Support\Facades\Route;

Route::get('/search/stats', [ApiDataController::class, 'getCommitStatsBySearchQueryAndDate']);
