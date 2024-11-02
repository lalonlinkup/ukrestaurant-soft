<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->index();
            $table->string('name');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('department_id');
            $table->string('bio_id', 20)->nullable();
            $table->date('joining');
            $table->string('gender', 20);
            $table->date('dob');
            $table->string('nid_no', 20)->nullable();
            $table->string('phone', 15);
            $table->string('email');
            $table->string('marital_status', 20);
            $table->string('father_name');
            $table->string('mother_name');
            $table->text('present_address');
            $table->text('permanent_address');
            $table->string('image')->nullable();
            $table->decimal('salary')->default(0);
            $table->string('reference', 60)->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('designation_id')->references('id')->on('designations');
            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::dropIfExists('employees');
    }
}
