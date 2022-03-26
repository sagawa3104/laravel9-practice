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
        Schema::create('recorded_inspection_detail_checkings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('recorded_inspection_detail_id');
            $table->string('type');
            $table->unsignedInteger('item_id')->nullable();
            $table->unsignedInteger('special_item_id')->nullable();
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
        Schema::dropIfExists('recorded_inspection_detail_checkings');
    }
};
