<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('employee_id')->unique();
            $table->string('specialty');
            $table->string('department');
            $table->date('hire_date');
            $table->string('office_location')->nullable();
            $table->string('office_hours')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('experience')->nullable();
            $table->text('publications')->nullable();
            $table->text('research_interests')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('professors');
    }
};