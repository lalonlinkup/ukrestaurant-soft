<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->index();
            $table->string('name', 100)->index();
            $table->string('phone', 15)->index();
            $table->string('email')->nullable();
            $table->string('nid', 20)->nullable();
            $table->string('gender', 20)->nullable();
            $table->decimal('previous_due')->default(0);
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->string('password')->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('reference_id')->references('id')->on('references');
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
        Schema::dropIfExists('customers');
    }
}
