<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('emp_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('dept_id');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();

            $table->string('address')->nullable();
            $table->enum('gender',['Male','Female','Other']);
            $table->date('dob')->nullable();
            $table->date('dob_nepali')->nullable();
            $table->string('doj')->nullable();

            $table->double('basic_salary',12,2)->default(0.0);
            $table->double('travelling',12,2)->default(0.0);
            $table->double('allowance',12,2)->default(0.0);
            $table->boolean('is_CIT')->default(0);
            $table->boolean('is_SSF')->default(0);
            $table->boolean('is_EPF')->default(0);
            $table->double('CIT',12,2)->default(0.0);
            $table->double('SSF',12,2)->default(0.0);
            $table->double('EPF',12,2)->default(0.0);

            
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->boolean('is_deleted')->default(0);
            $table->enum('is_login',['NO','YES'])->default('NO');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('company_id')->on('companies');
            $table->foreign('branch_id')->references('branch_id')->on('branches');
            
            $table->foreign('dept_id')->references('dept_id')->on('departments');
            $table->foreign('designation_id')->references('designation_id')->on('designations');
            $table->foreign('shift_id')->references('shift_id')->on('shifts');
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
        Schema::dropIfExists('employees');
    }
}
