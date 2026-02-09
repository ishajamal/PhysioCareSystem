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
        Schema::create('report_log', function (Blueprint $table) {
            $table->id('reportID');
            $table->string('reportType');
            $table->unsignedBigInteger('generatedBy');
            $table->datetime('generatedAt');
            $table->date('dateStart');
            $table->date('dateEnd');
            $table->foreign('generatedBy')->references('userID')->on('users');
        });
    }
//
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_log');
    }
};
