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
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_url_id')->nullable()->references('id')->on('page_urls')->nullOnDelete();
            $table->foreignId('domain_id')->nullable()->references('id')->on('domains')->nullOnDelete();
            $table->foreignId('visitor_id')->nullable()->references('id')->on('visitors')->nullOnDelete();
            $table->integer('position_x');
            $table->integer('position_y');
            $table->integer('screen_size_x');
            $table->integer('screen_size_y');
            $table->dateTime('datetime');
            $table->string('time_zone');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
