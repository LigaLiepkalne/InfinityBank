<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCryptoTransactionsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_transactions', function (Blueprint $table) {
            $table->decimal('price', 12, 6)->change();
            $table->decimal('total', 12, 6)->change();
            $table->decimal('profit_loss', 12, 6)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crypto_transactions', function (Blueprint $table) {
            $table->decimal('price', 12)->change();
            $table->decimal('total', 12)->change();
            $table->decimal('profit_loss', 12)->change();
        });
    }
}
