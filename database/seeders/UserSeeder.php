<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => 'Sayib',
                'email' => 'sayib@gmail.com',
                'password' => bcrypt('ganteng'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Roziq',
                'email' => 'roziq@gmail.com',
                'password' => bcrypt('ganteng'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Oji',
                'email' => 'oji@gmail.com',
                'password' => bcrypt('ganteng'),
                'email_verified_at' => now(),
            ]
        ])->each(function ($user) {
            User::create($user);
        });

        collect(['admin', 'moderator'])->each(fn ($role) => \App\Models\Role::create(['name' => $role])); //PHP 7.4
        User::find(1)->roles()->attach([1]);
        User::find(2)->roles()->attach([2]);
    }
}
