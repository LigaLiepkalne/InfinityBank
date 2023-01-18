<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_account_id');
            $table->string('symbol');
            $table->decimal('price', 12, 2);
            $table->decimal('amount', 12, 2);
            $table->decimal('total', 12, 2);
            $table->string('type');
            $table->timestamps();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');

            $table->decimal('profit_loss', 12, 2)->nullable();
            $table->string('sender_account_number', 20)->nullable();
            $table->string('recipient_account_number', 20)->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_surname')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_surname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_transactions');
    }
}
