<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->index();
            $table->unsignedBigInteger('menu_category_id');
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('unit_id');
            $table->float('vat')->default(0);
            $table->decimal('purchase_rate', 18,2)->default(0.00);
            $table->decimal('sale_rate', 18,2)->default(0.00);
            $table->decimal('wholesale_rate', 18,2)->default(0.00);
            $table->boolean('is_service')->default(false);
            $table->string('image')->nullable();
            $table->char('status', 1)->default('a');
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->ipAddress('last_update_ip');

            $table->foreign('menu_category_id')->references('id')->on('menu_categories');
            $table->foreign('unit_id')->references('id')->on('units');
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
        Schema::dropIfExists('menus');
    }
}
