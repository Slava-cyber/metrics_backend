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
        Schema::create('page_urls', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('domain_id')->constrained()->cascadeOnDelete();
            $table->boolean('pause')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_urls');
    }
};
