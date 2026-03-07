<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('roles')->where('name', 'Admin')->update(['name' => 'admin']);
        DB::table('roles')->where('name', 'Vendor')->update(['name' => 'vendor']);
        DB::table('roles')->where('name', 'Customer')->update(['name' => 'customer']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('roles')->where('name', 'admin')->update(['name' => 'Admin']);
        DB::table('roles')->where('name', 'vendor')->update(['name' => 'Vendor']);
        DB::table('roles')->where('name', 'customer')->update(['name' => 'Customer']);
    }
};
