<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_city')->after('shipping_address');
            $table->string('shipping_state')->after('shipping_city');
            $table->string('shipping_zipcode')->after('shipping_state');
            $table->string('shipping_country')->after('shipping_zipcode');
            $table->string('tracking_number')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_city',
                'shipping_state',
                'shipping_zipcode',
                'shipping_country',
                'tracking_number'
            ]);
        });
    }
}; 