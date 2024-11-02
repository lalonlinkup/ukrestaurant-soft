<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice', 20)->index();
            $table->date('date')->index();
            $table->unsignedBigInteger('supplier_id')->index();
            $table->char('type', 5)->comment('CP = Payment, CR = Receive')->index();
            $table->string('method', 10);
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->text('note')->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('supplier_id')->references('id')->on('suppliers');
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
        Schema::dropIfExists('supplier_payments');
    }
}
