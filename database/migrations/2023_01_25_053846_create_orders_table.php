<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('order_details_id')->nullable();
            $table->foreignId('address_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->string('cuppon_discounted_amount');
            $table->string('product_discounted_amount');
            $table->string('status', 50)->default('pending');
            $table->string('invoice', 100);
            $table->string('subscription_month', 50)->nullable();
            $table->string('payment_status', 50)->default('Not Paid');
            $table->string('total', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
