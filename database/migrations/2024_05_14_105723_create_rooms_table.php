<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index();
            $table->unsignedBigInteger('floor_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('room_type_id')->index();
            $table->string('name');
            $table->integer('bed');
            $table->integer('bath');
            $table->decimal('price', 18, 2);
            $table->text('note')->nullable();
            $table->string('image')->nullable();
            $table->char('status', 1)->default('a')->comment('a=active, d=deactive');
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('floor_id')->references('id')->on('floors');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('room_type_id')->references('id')->on('room_types');
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
        Schema::dropIfExists('rooms');
    }
}
