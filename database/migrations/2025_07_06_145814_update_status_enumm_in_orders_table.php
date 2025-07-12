<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("ALTER TABLE orders MODIFY status ENUM('cart', 'pending', 'new', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'cart'");
    }

    public function down(): void {
        DB::statement("ALTER TABLE orders MODIFY status ENUM('cart', 'pending', 'paid', 'shipped') DEFAULT 'cart'");
    }
};
