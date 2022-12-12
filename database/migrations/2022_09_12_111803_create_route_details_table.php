<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_details', function (Blueprint $table) {
            $table->id('route_id');
            $table->string('route_name')->unique();
            $table->string('show_route_name')->nullable();
            $table->string('route_path')->nullable();
            $table->string('method_name')->nullable();
            $table->string('method_type')->nullable();
            $table->string('controller_name')->nullable();
            $table->string('group_name')->nullable();

            $table->unsignedBigInteger('feature_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->timestamps();
            $table->foreign('feature_id')->references('feature_id')->on('features');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('route_details');
    }
}
