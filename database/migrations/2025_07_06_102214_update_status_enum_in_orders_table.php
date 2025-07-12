<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('new', 'pending', 'paid', 'shipped', 'cancelled', 'cart') DEFAULT 'new'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('new', 'pending', 'paid', 'shipped', 'cancelled') DEFAULT 'new'");
    }
};
