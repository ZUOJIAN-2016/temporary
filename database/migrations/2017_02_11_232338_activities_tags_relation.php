<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesTagsRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('activities_id');
            $table->unsignedInteger('tags_id');
            $table->text('opt1')->nullable();
            $table->text('opt2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities_tags');
    }
}
