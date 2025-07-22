<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('professor_id')->constrained()->onDelete('cascade');
            $table->string('year');
            $table->string('day');
            $table->time('time');
            $table->integer('duration'); // in minutes
            $table->string('room')->nullable();
            $table->integer('max_students')->default(50);
            $table->integer('enrolled_students')->default(0);
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};