<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('invoice', 20)->index();
            $table->date('date')->index();
            $table->string('type', 100)->nullable();
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->unsignedBigInteger('service_head_id');
            $table->decimal('amount', 18,2)->default(0.00);
            $table->text('description')->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('booking_id')->references('id')->on('booking_masters');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('service_head_id')->references('id')->on('service_heads');
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
        Schema::dropIfExists('services');
    }
}
