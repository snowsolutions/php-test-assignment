<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteCredentialsToSitesTable extends Migration
{
    /**
     * Group 2 Task 4: Add fields to site entity to store access key and base ID
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //pattAvoZ6fcaadblN.208cdeb66790301857ddaba5c171713bb45fcb521a80fa9e403c6e780da0eabc
        Schema::table('sites', function (Blueprint $table) {
            $table->string('airtable_access_key')->nullable();
            $table->string('airtable_base_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('airtable_access_key');
            $table->dropColumn('airtable_base_id');
        });
    }
}
