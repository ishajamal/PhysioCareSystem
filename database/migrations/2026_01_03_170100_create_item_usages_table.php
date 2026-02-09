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
        Schema::create('item_usages', function (Blueprint $table) {
            $table->id('itemUsageID');
            $table->foreignId('usageID')->constrained('usage_records', 'usageID')->onDelete('cascade');
            $table->foreignId('itemID')->constrained('item_maintenance_infos', 'itemID')->onDelete('cascade');
            $table->integer('quantityUsed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_usages');
    }
};
