<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice', 20)->index();
            $table->date('date')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->char('type', 5)->comment('CP = Payment, CR = Receive')->index();
            $table->string('method', 10);
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->decimal('discount', 18, 2)->default(0);
            $table->decimal('discountAmount', 18, 2)->default(0);
            $table->decimal('amount', 18, 2)->default(0);
            $table->decimal('previous_due', 18, 2)->default(0);
            $table->text('note')->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('booking_id')->references('id')->on('booking_masters');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->foreign('added_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_payments');
    }
}