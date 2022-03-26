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
        Schema::create('recorded_inspection_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('recorded_inspection_id');
            $table->string('type');
            $table->string('inspected_result');
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
        Schema::dropIfExists('recorded_inspection_details');
    }
};
