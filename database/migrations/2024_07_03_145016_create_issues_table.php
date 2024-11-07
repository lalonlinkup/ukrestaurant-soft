<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('invoice', 20)->index();
            $table->string('issue_to', 60);
            $table->unsignedBigInteger('table_id');
            $table->decimal('subtotal', 18,2)->default(0.00);
            $table->float('vat')->default(0);
            $table->decimal('vatAmount', 18,2)->default(0.00);
            $table->float('discount')->default(0);
            $table->decimal('discountAmount', 18,2)->default(0.00);
            $table->decimal('total', 18,2)->default(0.00);
            $table->text('description', 300)->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
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
        Schema::dropIfExists('issues');
    }
}
