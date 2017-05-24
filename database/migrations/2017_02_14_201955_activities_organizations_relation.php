<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesOrganizationsRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('activities_id');
            $table->unsignedInteger('organizations_id');
            $table->smallInteger('relation');
            $table->text('opt1')->nullable();
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
        Schema::dropIfExists('activities_organizations');
    }
}
