<?php

namespace Database\Seeders;

use App\Models\HRIS\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shifts = [
            [
                'company_id' => 1,
                'branch_id' => 1,
                'shift_type' => 'Morning',
                'start_shift' => '08:00:00',
                'end_shift' => '16:00:00',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'company_id' => 1,
                'branch_id' => 1,
                'shift_type' => 'Evening',
                'start_shift' => '16:00:00',
                'end_shift' => '00:00:00',
                'created_by' => 1,
                'updated_by' => 1
            ],

        ];

        foreach ($shifts as $shift) {
            $isExistshift = Shift::where('shift_type', $shift['shift_type'])
                ->where('company_id', 1)->first();
            if (!$isExistshift)
                Shift::create($shift);
        }
    }
}
