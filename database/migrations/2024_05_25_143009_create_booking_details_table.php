<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->index();
            $table->unsignedBigInteger('room_id')->index();
            $table->dateTime('checkin_date');
            $table->dateTime('checkout_date');
            $table->integer('days')->default(0)->index();
            $table->decimal('unit_price')->default(0)->index();
            $table->decimal('total')->default(0)->index();
            $table->char('checkout_status', 5)->default('false')->comment('true, false');
            $table->string('booking_status', 20)->default('booked')->comment('booked, checkin');
            $table->char('status', 1)->default('a');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('booking_id')->references('id')->on('booking_masters');
            $table->foreign('room_id')->references('id')->on('rooms');
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
        Schema::dropIfExists('booking_details');
    }
}
