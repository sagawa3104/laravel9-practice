<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recorded_products', function (Blueprint $table) {
            //
            $table->boolean('is_created_recorded_inspections')->after('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recorded_products', function (Blueprint $table) {
            //
            $table->dropColumn('is_created_recorded_inspections');
        });
    }
};
