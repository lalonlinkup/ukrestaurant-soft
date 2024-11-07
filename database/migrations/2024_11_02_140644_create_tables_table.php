<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index();
            $table->unsignedBigInteger('floor_id')->index();
            $table->unsignedBigInteger('incharge_id')->index();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('table_type_id')->index();
            $table->string('name');
            $table->string('capacity', 55);
            $table->text('location')->nullable();
            $table->integer('bed')->nullable();
            $table->integer('bath')->nullable();
            $table->decimal('price', 18, 2)->nullable();
            $table->text('note')->nullable();
            $table->string('image')->nullable();
            $table->string('booking_status', 20)->default('available')->comment('booked, available');
            $table->char('status', 1)->default('a')->comment('a=active, d=deactive');
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('floor_id')->references('id')->on('floors');
            $table->foreign('incharge_id')->references('id')->on('employees');
            $table->foreign('table_type_id')->references('id')->on('table_types');
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
        Schema::dropIfExists('tables');
    }
}
