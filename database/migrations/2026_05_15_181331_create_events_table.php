<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->dateTime('event_date');
            $table->string('location');
            $table->integer('max_attendees')->default(50);
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('event_date');
            $table->index('organizer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};