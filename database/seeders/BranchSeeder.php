<?php

namespace Database\Seeders;

use App\Models\HRIS\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'company_id' => 1,
                'branch_name' => 'Central Branch',
                'branch_type' => 'Main',
                'contact_number'=>'01-5562035',
                'mobile_number'=>'9888888888',
                'address'=>'Kathmandu',
                'created_by' => 1,
                'updated_by' => 1
            ],
        ];
        foreach ($branches as $branch) {
            $isExistBranch = Branch::where('branch_name', $branch['branch_name'])
                                    ->where('company_id',1)->first();
            if (!$isExistBranch)
            Branch::create($branch);
        }
    }
}
