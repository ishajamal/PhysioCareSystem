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
        Schema::create('item_maintenances', function (Blueprint $table) {
            $table->id('itemMaintenanceID');
            $table->foreignId('requestID')->constrained('maintenance_requests', 'requestID')->onDelete('cascade');
            $table->foreignId('itemID')->constrained('item_maintenance_infos', 'itemID')->onDelete('cascade');
            $table->string('itemIssue');
            $table->text('detailsMaintenance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_maintenances');
    }
};
