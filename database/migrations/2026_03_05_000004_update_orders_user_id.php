<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run this migration if the orders table has customer_id (old schema)
        // or doesn't have user_id column yet. If it already has user_id and no
        // customer_id, it means the table was created with the new schema.
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'customer_id')) {
            $driver = Schema::getConnection()->getDriverName();

            if ($driver === 'sqlite') {
                if (Schema::hasTable('orders_backup')) {
                    Schema::drop('orders_backup');
                }
                Schema::rename('orders', 'orders_backup');

                Schema::create('orders', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                    $table->string('customer_first_name')->nullable();
                    $table->string('customer_last_name')->nullable();
                    $table->string('customer_email')->nullable();
                    $table->string('customer_phone')->nullable();
                    $table->string('order_number')->unique();
                    $table->string('status')->default('pending');
                    $table->decimal('total_amount', 10, 2);
                    $table->json('shipping_address')->nullable();
                    $table->json('billing_address')->nullable();
                    $table->text('notes')->nullable();
                    $table->timestamps();

                    $table->index('status');
                    $table->index('created_at');
                });

                $selectColumns = [
                    'id',
                    'order_number',
                    'status',
                    'total_amount',
                    'shipping_address',
                    'billing_address',
                    'notes',
                    'created_at',
                    'updated_at',
                ];
                $optionalColumns = [
                    'user_id',
                    'customer_first_name',
                    'customer_last_name',
                    'customer_email',
                    'customer_phone',
                ];

                foreach ($optionalColumns as $column) {
                    if (Schema::hasColumn('orders_backup', $column)) {
                        $selectColumns[] = $column;
                    }
                }

                DB::table('orders_backup')->select($selectColumns)->orderBy('id')->chunkById(100, function ($rows) {
                    foreach ($rows as $row) {
                        DB::table('orders')->insert([
                            'id'                  => $row->id,
                            'user_id'             => property_exists($row, 'user_id') ? $row->user_id : null,
                            'customer_first_name' => property_exists($row, 'customer_first_name') ? $row->customer_first_name : null,
                            'customer_last_name'  => property_exists($row, 'customer_last_name') ? $row->customer_last_name : null,
                            'customer_email'      => property_exists($row, 'customer_email') ? $row->customer_email : null,
                            'customer_phone'      => property_exists($row, 'customer_phone') ? $row->customer_phone : null,
                            'order_number'        => $row->order_number,
                            'status'              => $row->status,
                            'total_amount'        => $row->total_amount,
                            'shipping_address'    => $row->shipping_address,
                            'billing_address'     => $row->billing_address,
                            'notes'               => $row->notes,
                            'created_at'          => $row->created_at,
                            'updated_at'          => $row->updated_at,
                        ]);
                    }
                });

                Schema::drop('orders_backup');
            } else {
                Schema::table('orders', function (Blueprint $table) {
                    if (Schema::hasColumn('orders', 'customer_id')) {
                        $table->dropForeign(['customer_id']);
                        $table->dropColumn('customer_id');
                    }
                    if (! Schema::hasColumn('orders', 'user_id')) {
                        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                        $table->index('user_id');
                    }
                });
            }
        }

        if (Schema::hasTable('customers')) {
            Schema::dropIfExists('customers');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            $driver = Schema::getConnection()->getDriverName();

            if ($driver === 'sqlite') {
                if (Schema::hasTable('orders_backup')) {
                    Schema::drop('orders_backup');
                }
                Schema::rename('orders', 'orders_backup');

                Schema::create('orders', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('customer_id')->nullable();
                    $table->string('order_number')->unique();
                    $table->string('status')->default('pending');
                    $table->decimal('total_amount', 10, 2);
                    $table->json('shipping_address')->nullable();
                    $table->json('billing_address')->nullable();
                    $table->text('notes')->nullable();
                    $table->timestamps();

                    $table->index('status');
                    $table->index('created_at');
                });

                DB::table('orders_backup')->select(
                    'id',
                    'order_number',
                    'status',
                    'total_amount',
                    'shipping_address',
                    'billing_address',
                    'notes',
                    'created_at',
                    'updated_at'
                )->orderBy('id')->chunkById(100, function ($rows) {
                    foreach ($rows as $row) {
                        DB::table('orders')->insert([
                            'id'               => $row->id,
                            'customer_id'      => null,
                            'order_number'     => $row->order_number,
                            'status'           => $row->status,
                            'total_amount'     => $row->total_amount,
                            'shipping_address' => $row->shipping_address,
                            'billing_address'  => $row->billing_address,
                            'notes'            => $row->notes,
                            'created_at'       => $row->created_at,
                            'updated_at'       => $row->updated_at,
                        ]);
                    }
                });

                Schema::drop('orders_backup');
            } else {
                Schema::table('orders', function (Blueprint $table) {
                    if (Schema::hasColumn('orders', 'user_id')) {
                        $table->dropForeign(['user_id']);
                        $table->dropIndex(['user_id']);
                        $table->dropColumn('user_id');
                    }
                    if (! Schema::hasColumn('orders', 'customer_id')) {
                        $table->foreignId('customer_id')->nullable();
                    }
                });
            }
        }

        if (! Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email');
                $table->string('phone')->nullable();
                $table->timestamps();

                $table->index('email');
                $table->index('user_id');
            });
        }
    }
};
