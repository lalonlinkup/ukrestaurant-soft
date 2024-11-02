<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_payment_id');
            $table->unsignedBigInteger('employee_id');
            $table->decimal('salary')->default(0);
            $table->decimal('benefit')->default(0);
            $table->decimal('deduction')->default(0);
            $table->decimal('net_payable')->default(0);
            $table->decimal('payment')->default(0);
            $table->string('comment', 150)->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('employee_payment_id')->references('id')->on('employee_payments');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('added_by')->references('id')->on('users');
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
        Schema::dropIfExists('employee_payment_details');
    }
}
