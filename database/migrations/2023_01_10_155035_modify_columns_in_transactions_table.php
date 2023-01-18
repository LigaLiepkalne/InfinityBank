<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account-transactions', function (Blueprint $table) {
            $table->dropColumn('currency');
            $table->dropColumn('amount');
            $table->dropColumn('sender_recipient_account');
            $table->dropColumn('sender_recipient_name');
            $table->dropColumn('sender_recipient_surname');
            $table->string('received_currency')->nullable()->after('user_id')->change();
            $table->string('sent_currency')->nullable()->after('received_currency')->change();
            $table->string('sender_account')->nullable()->after('recipient_account')->change();
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
            //
        });
    }
}
