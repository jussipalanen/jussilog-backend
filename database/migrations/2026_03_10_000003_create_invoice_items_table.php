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
        Schema::create(
            'invoice_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
                $table->foreignId('order_item_id')->nullable()->constrained('order_items')->nullOnDelete();
                $table->string('type')->default('product'); // product, shipping, discount, adjustment
                $table->string('description');
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 10, 2);
                $table->decimal('tax_rate', 5, 4)->default(0); // e.g. 0.2400 = 24%
                $table->decimal('total', 10, 2);
                $table->timestamps();

                $table->index('invoice_id');
                $table->index('order_item_id');
                $table->index('type');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
