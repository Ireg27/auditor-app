<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedule_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->dateTime('scheduled_date')->nullable();
            $table->enum('status', ['not_started', 'in_progress', 'done'])->default('not_started');
            $table->foreignId('user_id')->nullable();
            $table->text('assessment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_jobs');
    }
};
