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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('type');
            $table->string('status');
            $table->decimal('total',15,3)->default(0);
            $table->string('user');
            $table->json('payload');
            $table->integer('attempts')->default(0);
            $table->string('message')->nullable();
            $table->boolean('sync')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
