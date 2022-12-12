<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            [
                'feature_name' => 'Config',
                'description' => 'Basic Setup for Super Admin',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'feature_name' => 'Dashboard',
                'description' => 'Dashboard',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'feature_name' => 'HRIS',
                'description' => 'HRIS',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'feature_name' => 'Payroll',
                'description' => 'Payroll',
                'created_by' => 1,
                'updated_by' => 1
            ]
        ];

        foreach ($features as $feature)
            Feature::create($feature);
    }
}
