<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->name(),
            'company_phone' => $this->faker->numerify('##########'),

            'company_mobile' => $this->faker->numerify('##########'),
            'company_email' => $this->faker->unique()->safeEmail(),
            'company_name' => $this->faker->name(),
            'company_address' => $this->faker->address(),
            'created_by' => 1,//rand(1,100),
            'updated_by' => 1, //rand(1,100),

        ];
    }
}
