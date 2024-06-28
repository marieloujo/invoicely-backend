<?php

use App\Enums\TypeTransaction;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs("transactionable");
            $table->foreignUuid('product_id')
                ->references('id')
                ->on('products');
            $table->enum("type", TypeTransaction::values());
            $table->integer("quantity");
            $table->text("motif")->nullable();
            $table->boolean("status");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
