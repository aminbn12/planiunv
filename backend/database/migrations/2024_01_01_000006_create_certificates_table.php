<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['inscription', 'reussite', 'notes', 'stage']);
            $table->enum('status', ['pending', 'processing', 'ready', 'delivered'])->default('pending');
            $table->date('request_date');
            $table->date('completion_date')->nullable();
            $table->text('reason')->nullable();
            $table->integer('copies')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};