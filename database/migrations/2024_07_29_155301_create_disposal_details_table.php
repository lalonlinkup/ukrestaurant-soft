<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disposal_id');
            $table->unsignedBigInteger('asset_id');
            $table->decimal('price', 18,2)->default(0.00);
            $table->float('quantity')->default(0);
            $table->decimal('total', 18,2)->default(0.00);
            $table->string('disposal_status', 40);
            $table->char('status', 1)->default('a')->index();
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');
            
            $table->foreign('disposal_id')->references('id')->on('disposals');
            $table->foreign('asset_id')->references('id')->on('assets');
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
        Schema::dropIfExists('disposal_details');
    }
}
