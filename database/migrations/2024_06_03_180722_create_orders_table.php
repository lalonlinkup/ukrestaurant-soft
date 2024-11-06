<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice', 20)->unique()->index();
            $table->date('date')->index();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->string('customer_name', 60)->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->text('customer_address')->nullable();
            $table->decimal('sub_total', 18, 2)->default(0.00);
            $table->decimal('charge', 18, 2)->default(0.00);
            $table->decimal('discount', 18, 2)->default(0.00);
            $table->decimal('vat', 18, 2)->default(0.00);
            $table->decimal('total', 18, 2)->default(0.00);
            $table->decimal('cashPaid', 18, 2)->default(0.00);
            $table->decimal('bankPaid', 18, 2)->default(0.00);
            $table->unsignedBigInteger('bank_account_id')->nullable()->index();
            $table->decimal('returnAmount', 18, 2)->default(0.00);
            $table->decimal('paid', 18, 2)->default(0.00);
            $table->decimal('due', 18, 2)->default(0.00);
            $table->text('note')->nullable();
            $table->char('status', 1)->default('a');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('room_id')->references('id')->on('rooms');
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
        Schema::dropIfExists('orders');
    }
}
