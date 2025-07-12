<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('order_items', function (Blueprint $table) {
        // Tambahkan hanya jika kolom total_amount belum ada
        if (!Schema::hasColumn('order_items', 'total_amount')) {
            $table->decimal('total_amount', 15, 2)->default(0)->after('unit_amount');
        }
    });
}

    public function down(): void
{
    Schema::table('order_items', function (Blueprint $table) {
        if (Schema::hasColumn('order_items', 'total_amount')) {
            $table->dropColumn('total_amount');
        }
    });
}

};
