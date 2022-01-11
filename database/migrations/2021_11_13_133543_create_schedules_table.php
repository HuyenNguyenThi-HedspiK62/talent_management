<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->text('schedule_name');
            $table->date('date');
            $table->text('location');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('reviewer');
            $table->unsignedInteger('status')->default(0)->comment('0: not started, 1: processing, 2: done, 3: suspend');
            $table->text('information')->nullable();
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
        Schema::dropIfExists('schedules');
    }
}
