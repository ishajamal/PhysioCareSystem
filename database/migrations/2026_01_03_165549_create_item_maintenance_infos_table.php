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
        Schema::create('item_maintenance_infos', function (Blueprint $table) {
            $table->id('itemID');
            $table->string('itemName');
            $table->integer('quantity');
            $table->string('stockLevel');
            $table->string('condition');
            $table->string('status');
            $table->string('category');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_maintenance_infos');
    }
};
