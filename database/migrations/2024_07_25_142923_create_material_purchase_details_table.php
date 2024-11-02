<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_purchase_id');
            $table->unsignedBigInteger('material_id');
            $table->float('quantity')->default(0);
            $table->decimal('price', 18,2)->default(0.00);
            $table->decimal('total', 18,2)->default(0.00);
            $table->string('note')->nullable();
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('material_purchase_id')->references('id')->on('material_purchases');
            $table->foreign('material_id')->references('id')->on('materials');
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
        Schema::dropIfExists('material_purchase_details');
    }
}
