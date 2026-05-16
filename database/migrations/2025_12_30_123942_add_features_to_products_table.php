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
        Schema::table('products', function (Blueprint $table) {
            $table->json('sizes')->nullable()->after('stock');
            $table->decimal('offer_price', 10, 2)->nullable()->after('price');
            $table->dateTime('offer_start_date')->nullable()->after('offer_price');
            $table->dateTime('offer_end_date')->nullable()->after('offer_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sizes', 'offer_price', 'offer_start_date', 'offer_end_date']);
        });
    }
};
