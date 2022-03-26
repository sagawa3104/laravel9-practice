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
        Schema::create('recorded_inspection_detail_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('recorded_inspection_detail_id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('x_point');
            $table->unsignedInteger('y_point');
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
        Schema::dropIfExists('recorded_inspection_detail_mappings');
    }
};
