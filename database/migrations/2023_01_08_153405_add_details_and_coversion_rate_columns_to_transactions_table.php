<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsAndCoversionRateColumnsToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account-transactions', function (Blueprint $table) {
            $table->string('details')->nullable()->after('recipient_surname');
            $table->decimal('conversion_rate', 12, 2)->nullable()->after('currency');
            $table->decimal('received_amount', 12, 2)->nullable()->after('amount');
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
