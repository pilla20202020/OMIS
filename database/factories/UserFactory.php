<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arr = ['SUPER ADMIN','COMPANY','EMPLOYEE'];
        return [
            // 'User_type' => $arr[array_rand($arr,1),
            'User_type' => 'SUPER ADMIN',
            // 'first_name' => $this->faker->name(),
            'first_name' => 'Super',
            'last_name' => 'Admin',
            // 'last_name' => $this->faker->name(),
            'mobile' => $this->faker->numerify('##########'),
            // 'email' => $this->faker->unique()->safeEmail(),
            'email' => 'superadmin@example.net',
            'email_verified_at' => now(),
            'password' => '$2a$12$jcGRv3jUgIEECkgb0asfBO7CKWAlbMOYxdpobTU/JM0yK42Jwi05u', // password
            'remember_token' => Str::random(10),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
