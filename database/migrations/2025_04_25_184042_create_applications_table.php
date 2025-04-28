<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('hackathon_id')->constrained('hackathons');
            $table->foreignId('team_id')->nullable()->constrained('teams');
            $table->string('status')->default('pending'); // pending, accepted, rejected, waitlisted
            $table->text('motivation')->nullable();
            $table->text('experience')->nullable();
            $table->text('skills')->nullable();
            $table->boolean('is_checked_in')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
}; 