<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string("product_name");
            /* $table->string("company_name"); */
            $table->integer("price");
            $table->integer("stock");
            $table->string("comment");
            $table->string('filename');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            /* $table->foreign('company_id')->references('id')->on('companies'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
