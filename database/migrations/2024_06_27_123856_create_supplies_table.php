<?php

use App\Enums\SupplyStatus;
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
        Schema::create('supplies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->nullable()
                ->references('id')
                ->on('users');
            $table->foreignUuid('reception_clerk_id')
                ->nullable()
                ->references('id')
                ->on('users');
            $table->string('reference')->unique();
            $table->string('delivery_person')->nullable();
            $table->enum('status', SupplyStatus::values())
                ->default(SupplyStatus::PENDING->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
