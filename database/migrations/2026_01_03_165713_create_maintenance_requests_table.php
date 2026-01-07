<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id('requestID');
            $table->foreignId('userID')->constrained('users', 'userID')->onDelete('cascade');
            $table->dateTime('dateSubmitted');
            $table->string('status');
            $table->foreignId('submittedBy')->constrained('users', 'userID');
            $table->boolean('isRead')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
