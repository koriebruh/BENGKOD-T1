<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

//    //FACTORY UNUTK GENERATE RANDOM USERS
//    public function RandUsers()
//    {
//        return [
//            'nama' => $this->faker->name,
//            'alamat' => $this->faker->address,
//            'no_hp' => $this->faker->phoneNumber,
//            'email' => $this->faker->unique()->safeEmail,
//            'role' => $this->faker->randomElement(['dokter', 'pasien']), // Role acak antara dokter dan pasien
//            'password' => bcrypt('password123'), // password terenkripsi
//            'created_at' => now(),
//            'updated_at' => now(),
//        ];
//    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
