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
        Schema::create('facture_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('facture_id')
                ->references('id')
                ->on('factures');
            $table->foreignUuid('price_id')
                ->references('id')
                ->on('prices');
            $table->unsignedInteger('quantity');
            $table->double('total_amount_excl');
            $table->double('total_amount_incl');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_items');
    }
};
