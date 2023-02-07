<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = [
            [
            "name" => 'Leslie Alexander',
            "email" => 'leslie.alexander@example.com',
            "imageUrl" =>
                'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
            [
            "name" => 'Tom Cook',
            "email" => 'tom.cook@example.com',
            "imageUrl" =>
                'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
            [
            "name" => 'Whitney Francis',
            "email" => 'whitney.francis@example.com',
            "imageUrl" =>
                'https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
            [
            "name" => 'Leonard Krasner',
            "email" => 'leonard.krasner@example.com',
            "imageUrl" =>
                'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
            [
            "name" => 'Floyd Miles',
            "email" => 'floyd.miles@example.com',
            "imageUrl" =>
                'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
            [
            "name" => 'Emily Selman',
            "email" => 'emily.selman@example.com',
            "imageUrl" =>
                'https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
        ];

        foreach ($patients as $patient) {
            User::firstOrCreate([
                        "name" => $patient["name"],
                        "email" => $patient["email"],
                        "avatar" => $patient["imageUrl"],
                    ]);
        }
    }
}
