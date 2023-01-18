<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account-transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('currency');
            $table->decimal('amount', 12, 2);
            $table->string('sender_account_number')->nullable();
            $table->string('recipient_account_number')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_surname')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_surname')->nullable();
            $table->string('type');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account-transactions');
    }
}
