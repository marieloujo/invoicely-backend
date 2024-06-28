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
        Schema::create('prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('priceable');
            $table->double('unit_price_excl');
            $table->double('unit_price_incl');
            $table->dateTime("start_date");
            $table->dateTime("end_date")->nullable();
            $table->boolean("status")->default(TRUE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
