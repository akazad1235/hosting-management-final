<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->text('message')->nullable();
            $table->string('file')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
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
        Schema::create('conversions', function (Blueprint $table) {
            $table->dropForeign('admin_id')->change();
        });
        ;
    }
}
