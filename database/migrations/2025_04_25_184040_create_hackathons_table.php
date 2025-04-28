<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hackathons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('logo_url')->nullable();
            $table->string('website_url')->nullable();
            $table->dateTime('registration_start');
            $table->dateTime('registration_end');
            $table->dateTime('event_start');
            $table->dateTime('event_end');
            $table->string('location');
            $table->text('challenges')->nullable();
            $table->text('sponsors')->nullable();
            $table->text('prizes')->nullable();
            $table->text('rules')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hackathons');
    }
}; 