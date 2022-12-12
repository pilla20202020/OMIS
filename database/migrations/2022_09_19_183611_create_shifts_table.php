<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id('shift_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('branch_id');

            $table->string('shift_type');
            $table->time('start_shift');
            $table->time('end_shift');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
            $table->foreign('company_id')->references('company_id')->on('companies');
            $table->foreign('branch_id')->references('branch_id')->on('branches');
            
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
        Schema::dropIfExists('shifts');
    }
}
