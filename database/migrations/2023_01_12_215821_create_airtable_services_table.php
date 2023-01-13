<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirtableServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Group 3 - Task 5: Create tables to store models, drawings and services structure
         */
        Schema::create('airtable_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_id')->unique();
            $table->string('name');
            $table->mediumText('instructions')->nullable();
            $table->mediumText('condition')->nullable();
            $table->boolean('recurring')->nullable();
            $table->integer('calendar_interval')->nullable();
            $table->string('calendar_interval_unit')->nullable();
            $table->integer('running_hour_interval')->nullable();
            $table->integer('alternative_interval')->nullable();
            $table->text('alternative_interval_description')->nullable();
            $table->string('service_group')->nullable();
            $table->mediumText('model')->nullable();
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
        Schema::dropIfExists('airtable_services');
    }
}
