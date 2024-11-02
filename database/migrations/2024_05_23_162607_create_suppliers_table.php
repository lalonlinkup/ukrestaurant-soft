<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->index();
            $table->string('name', 100)->index();
            $table->string('type', 10)->index();
            $table->string('phone', 15)->index();
            $table->string('email', 100)->nullable();
            $table->string('office_phone', 15)->nullable();
            $table->string('address')->nullable();
            $table->string('owner_name', 100)->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->decimal('previous_due')->default(0);
            $table->string('image')->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('district_id')->references('id')->on('districts');
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
        Schema::dropIfExists('suppliers');
    }
}
