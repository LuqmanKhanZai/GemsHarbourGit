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
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->bigInteger('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->nullOnDelete();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();

            $table->string('title');
            $table->string('cover');
            $table->string('url');
            $table->longText('description');
            $table->string('dimension');
            $table->float('dimension_x');
            $table->float('dimension_y');
            // $table->float('dimension_3');
            $table->float('weight')->nullable();
            $table->string('certified')->nullable();
            $table->string('clarity_i')->nullable();
            $table->string('clarity_if')->nullable();
            $table->string('clarity_si')->nullable();
            $table->string('clarity_vs')->nullable();
            $table->string('clarity_vvs')->nullable();
            $table->string('no_treatment')->nullable();
            // LIsting Details
            $table->enum('listing_type',['auction','buy_now','Standard Type','YZ']);
            $table->string('duration')->nullable();
            $table->string('item_type')->nullable();
            // Pricing Details
            $table->string('starting_price');
            $table->string('reserve_price');
            // But It Now
            $table->string('now_price')->nullable();
            $table->string('rrp_price')->nullable();
            $table->enum('offer', ['enabled','disabled']);
            $table->string('start_date')->nullable();
            // Shipping Details
            $table->enum('shipping_details' , ['normal','free']);
            $table->float('shipping_price');
            $table->enum('shipping_cost' , ['buyer','seller']);
            $table->string('status')->default('Active');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
