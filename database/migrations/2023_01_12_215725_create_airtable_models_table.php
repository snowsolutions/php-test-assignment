<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirtableModelsTable extends Migration
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
        Schema::create('airtable_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->text('description')->nullable();
            $table->string('unit')->nullable();
            $table->text('note')->nullable();
            $table->mediumText('parents')->nullable();
            $table->mediumText('children')->nullable();
            $table->mediumText('services')->nullable();
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
        Schema::dropIfExists('airtable_models');
    }
}
