<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationsToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('supported_by')->nullable();
            $table->dateTime('read_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('supported_by')->change();
            $table->dateTime('read_at')->change();
        });
    }
}
