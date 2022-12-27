<?php

namespace Database\Seeders;

use App\Models\Payroll\LeaveType;
use App\Models\Payroll\LeaveTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $absenttype=[
            [
                'name'=>'Annual Leave',
                'slug'=>'annual-leave',
                'total_days'=>'20',
            ],
            [
                'name'=>'Sick Leave',
                'slug'=>'sick-leave',
                'total_days'=>'10',
            ]
        ];
        DB::table('leave_types')->insert($absenttype);
    }
}
