<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('name');
            $table->string('subject');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('message');
            $table->integer('is_read')->default(0)->comment('0 = Not Read , 1 = Read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
