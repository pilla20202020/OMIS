<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('branch_id');
            $table->char('employee_id',15)->nullable();//For Future use to PRovide Employee Id
            $table->year('year');
            $table->date('date');
            $table->enum('status',['P','A','L','H']);
            $table->enum('present_type',['Full','Half'])->default('Full');
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->unsignedInteger('late_minute')->nullable();
            $table->string('reason')->nullable();
            $table->datetime('time_in')->nullable();
            $table->datetime('time_out')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('emp_id')->references('emp_id')->on('employees');
            $table->foreign('company_id')->references('company_id')->on('companies');
            $table->foreign('branch_id')->references('branch_id')->on('branches');

            $table->foreign('leave_type_id')->references('id')->on('leave_types');


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
        Schema::dropIfExists('employee_attendances');
    }
}
