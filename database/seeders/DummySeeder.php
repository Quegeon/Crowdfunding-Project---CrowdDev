<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'id' => Str::orderedUuid(),
            'name' => 'SuperAdmin',
            'username' => 'superadmin1',
            'password' => bcrypt('12345678'),
            'encrypt_view' => encrypt('12345678'),
            'email' => 'superadmin1@crowddev.id'
        ]);

        User::create([
            'id' => Str::orderedUuid(),
            'name' => 'DummyUser',
            'username' => 'dummyuser1',
            'password' => bcrypt('12345678'),
            'encrypt_view' => encrypt('12345678'),
            'email' => 'dummyuser1@crowddev.id',
            'payment_credential' => '123456'
        ]);

        User::create([
            'id' => Str::orderedUuid(),
            'name' => 'DummyUserTwo',
            'username' => 'dummyuser2',
            'password' => bcrypt('12345678'),
            'encrypt_view' => encrypt('12345678'),
            'email' => 'dummyuser2@crowddev.id',
            'payment_credential' => '123456'
        ]);

        Company::create([
            'id' => Str::orderedUuid(),
            'username' => 'dummycompany1',
            'password' => bcrypt('12345678'),
            'encrypt_view' => encrypt('12345678'),
            'company_email' => 'dummycompany1@crowddev.id',
            'company_name' => 'Dummy Company',
            'work_field' => 'Software Developement',
            'country' => 'Indonesia',
            'company_description' => 'Strive for the better',
            'name' => 'DummyUser',
            'position' => 'CEO',
            'personal_email' => 'dummyuser1@crowddev.id'
        ]);
    }
}
