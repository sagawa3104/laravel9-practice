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
        Schema::table('recorded_inspections', function (Blueprint $table) {
            //
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recorded_inspections', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};