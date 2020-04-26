<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBodyAndTitleToPullRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pull_requests', function (Blueprint $table) {
            $table->string('title', 1000);
            $table->longText('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pull_requests', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('body');
        });
    }
}
