<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCryptoTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_transactions', function (Blueprint $table) {
            $table->dropColumn('sender_account_number');
            $table->dropColumn('recipient_account_number');
            $table->dropColumn('sender_name');
            $table->dropColumn('sender_surname');
            $table->dropColumn('recipient_name');
            $table->dropColumn('recipient_surname');
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
            $table->string('sender_account_number', 20)->nullable();
            $table->string('recipient_account_number', 20)->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_surname')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_surname')->nullable();
        });
    }
}
