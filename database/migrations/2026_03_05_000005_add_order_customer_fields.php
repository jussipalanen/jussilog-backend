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
        // If customer fields already exist (from create_orders_table), skip this migration
        if (Schema::hasColumn('orders', 'customer_first_name')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_first_name')->nullable()->after('user_id');
            $table->string('customer_last_name')->nullable()->after('customer_first_name');
            $table->string('customer_email')->nullable()->after('customer_last_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            $table->index('customer_email', 'orders_customer_email_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_customer_email_index');
            $table->dropColumn([
                'customer_first_name',
                'customer_last_name',
                'customer_email',
                'customer_phone',
            ]);
        });
    }
};
