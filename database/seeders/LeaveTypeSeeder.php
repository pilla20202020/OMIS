<?php

namespace Database\Seeders;

use App\Models\Payroll\LeaveType;
use App\Models\Payroll\LeaveTypes;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leaveTypes = [
            [
                'leave_type' => 'Sick',
                'company_id' => 1,
                'days' => 10,
                'description' => '',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'leave_type' => 'Paid',
                'company_id' => 1,
                'days' => 20,
                'description' => '',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'leave_type' => 'Unpaid',
                'company_id' => 1,
                'days' => 12,
                'description' => '',
                'created_by' => 1,
                'updated_by' => 1
            ],
            
        ];

        
            foreach ($leaveTypes as $leaveType) {
                $existleaveType = LeaveType::where('leave_type', $leaveType['leave_type'])
                    ->where('company_id', 1)->first();
                if (!$existleaveType)
                LeaveType::create($leaveType);
            }
    }
}
