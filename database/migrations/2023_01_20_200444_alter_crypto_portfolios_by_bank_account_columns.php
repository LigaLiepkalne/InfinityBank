<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCryptoPortfoliosByBankAccountColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_portfolios_by_bank_account', function (Blueprint $table) {
            $table->decimal('price', 12, 6)->change();
            $table->decimal('amount', 12, 6)->change();
            $table->decimal('total', 12, 6)->change();
            $table->decimal('price_sum', 12, 6)->change();
            $table->decimal('avg_price', 12, 6)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crypto_portfolios_by_bank_account', function (Blueprint $table) {
            $table->decimal('price', 12)->change();
            $table->decimal('amount', 12)->change();
            $table->decimal('total', 12)->change();
            $table->decimal('price_sum', 12)->change();
            $table->decimal('avg_price', 12)->change();
        });
    }
}
