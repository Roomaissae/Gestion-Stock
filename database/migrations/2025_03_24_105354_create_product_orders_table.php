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
        Schema::create('product_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->decimal('sale_price')->default(1);
                $table->integer('quantity')->default(1);
                $table->timestamps();
                $table->decimal('price')->default(1);
                // Prevent duplicate enrollments

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_orders');
        Schema::table('product_orders', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
