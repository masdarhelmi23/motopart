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
    Schema::table('orders', function (Blueprint $table) {
       // $table->string('payment_status')->default('pending')->nullable();
       // $table->string('currency')->default('idr')->nullable();
       // $table->string('shipping_method')->nullable();
        $table->text('notes')->nullable();
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['payment_status', 'currency', 'shipping_method', 'notes']);
    });
}
};
