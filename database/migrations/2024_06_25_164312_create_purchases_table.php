<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice', 20)->index();
            $table->date('date')->index();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->decimal('sub_total', 18,2)->default(0.00);
            $table->float('vat')->default(0);
            $table->decimal('vatAmount', 18,2)->default(0.00);
            $table->float('discount')->default(0);
            $table->decimal('discountAmount', 18,2)->default(0.00);
            $table->decimal('transport', 18,2)->default(0.00);
            $table->decimal('total', 18,2)->default(0.00);
            $table->decimal('paid', 18,2)->default(0.00);
            $table->decimal('due', 18,2)->default(0.00);
            $table->decimal('previous_due', 18,2)->default(0.00);
            $table->text('description', 300)->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('employee_id')->references('id')->on('employees');
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
        Schema::dropIfExists('purchases');
    }
}
