<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->integer('quantity');
                $table->decimal('price', 10, 2);
                $table->timestamps();
            });
        } else {
            // Add any missing columns if the table exists
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'price')) {
                    $table->decimal('price', 10, 2)->after('quantity');
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}; 