<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGithubIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_issues', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('url');
            $table->enum('state', ['open', 'closed']);
            $table->dateTime('issue_created_at');
            $table->bigInteger('package_id')->unsigned();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('github_issues');
    }
}
