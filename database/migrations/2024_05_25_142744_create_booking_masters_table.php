<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_masters', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->index();
            $table->string('date', 20);
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('is_other', 5)->default('false')->index();
            $table->integer('others_member')->default(0);
            $table->decimal('subtotal')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('discountAmount')->default(0);
            $table->decimal('vat')->default(0);
            $table->decimal('vatAmount')->default(0);
            $table->decimal('total')->default(0);
            $table->decimal('advance')->default(0);
            $table->decimal('due')->default(0);
            $table->text('note')->nullable();            
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

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
        Schema::dropIfExists('booking_masters');
    }
}
