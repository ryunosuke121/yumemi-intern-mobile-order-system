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
        Schema::create('m_subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->integer('price');
            $table->integer('max_table_count');
            $table->string('billing_cycle', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_subscription_plans');
    }
};
