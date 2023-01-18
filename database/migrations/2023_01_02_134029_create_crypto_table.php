<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_portfolios_by_bank_account', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_account_id');
            $table->string('symbol');
            $table->decimal('price', 12, 2);
            $table->decimal('amount', 12, 2);
            $table->decimal('total', 12, 2);
            $table->decimal('price_sum', 12, 2);
            $table->integer('purchase_count');
            $table->decimal('avg_price', 12, 2);
            $table->timestamps();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_portfolios_by_bank_account');
    }
}
