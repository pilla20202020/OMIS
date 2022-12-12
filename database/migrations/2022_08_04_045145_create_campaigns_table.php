<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->string('details')->nullable();
            $table->string('banner')->nullable();
            $table->string('ogImage')->nullable();
            $table->date('starts')->nullable();
            $table->date('ends')->nullable();
            $table->text('ogtags')->nullable();
            $table->text('success_message')->nullable();
            $table->text('sms_message')->nullable();
            $table->text('coupon_codes')->nullable();
            $table->string('url')->nullable();
            $table->string('keywords')->nullable();
            $table->text('headers')->nullable();
            $table->string('description')->nullable();
            $table->text('email_success')->nullable();
            $table->text('offered_course')->nullable();
            $table->string('display_order')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status',['active','in_active'])->nullable();
            $table->bigInteger('created_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->date('created_on')->nullable();
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
        Schema::dropIfExists('tbl_campaigns');
    }
}
