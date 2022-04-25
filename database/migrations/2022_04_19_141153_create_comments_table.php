<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();


            if (env('DB_CONNECTION') === 'sqlite_testing') {
                $table->text('content')->default('');
            } else {
                $table->text('content');
            }

            if (env('DB_CONNECTION') === 'sqlite_testing') {
                $table->unsignedBigInteger('blog_post_id')->default(0);
            } else {
                $table->unsignedBigInteger('blog_post_id')->index()->nullable();
            }
            $table->foreign('blog_post_id')->references('id')->on('blog_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
