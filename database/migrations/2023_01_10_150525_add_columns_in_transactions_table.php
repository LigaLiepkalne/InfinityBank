<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account-transactions', function (Blueprint $table) {
            $table->string('sent_currency')->after('id');
            $table->string('received_currency')->after('id');
            $table->float('sent_amount')->after('conversion_rate');
            $table->float('received_amount')->after('conversion_rate');
            $table->string('sender_account')->after('amount');
            $table->string('recipient_account')->after('amount');
            $table->string('sender_name')->after('recipient_account');
            $table->string('sender_surname')->after('sender_name');
            $table->string('recipient_name')->after('sender_surname');
            $table->string('recipient_surname')->after('recipient_name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account-transactions', function (Blueprint $table) {

        });
    }
}
