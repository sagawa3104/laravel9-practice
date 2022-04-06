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
        Schema::table('recorded_inspection_detail_checkings', function (Blueprint $table) {
            //
            $table->renameColumn('special_item_id', 'specification_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recorded_inspection_detail_checkings', function (Blueprint $table) {
            //
            $table->renameColumn('specification_id', 'special_item_id');

        });
    }
};
