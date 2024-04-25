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
            'name' => 'Aldy Aditia Hidayat',
            'username' => 'aldyah1',
            'password' => bcrypt('12345678'),
            'encrypt_view' => encrypt('12345678'),
            'email' => 'dummyuser1@crowddev.id',
            'payment_credential' => bcrypt('123456')
        ]);

        User::create([
            'id' => Str::orderedUuid(),
            'name' => 'Alvin Dwi Putra',
            'username' => 'alvinddpp1',
            'password' => bcrypt('12345678'),
            'encrypt_view' => encrypt('12345678'),
            'email' => 'dummyuser2@crowddev.id',
            'payment_credential' => bcrypt('123456')
        ]);

        Company::create([
            'id' => Str::orderedUuid(),
            'username' => 'companyone',
            'password' => bcrypt('12345678'),
            'encrypt_view' => encrypt('12345678'),
            'company_email' => 'dummycompany1@crowddev.id',
            'company_name' => 'Company One',
            'work_field' => 'Software Developement',
            'country' => 'Indonesia',
            'company_description' => 'Strive for the better',
            'name' => 'Rafli Sodri',
            'position' => 'CEO',
            'personal_email' => 'raflisodri1@crowddev.id'
        ]);

        Company::create([
            'id' => Str::orderedUuid(),
            'username' => 'companytwo',
            'password' => bcrypt('12345678'),
            'encrypt_view' => encrypt('12345678'),
            'company_email' => 'dummycompany2@crowddev.id',
            'company_name' => 'Company Two',
            'work_field' => 'Public Relations',
            'country' => 'Indonesia',
            'company_description' => 'Strive for the better',
            'name' => 'Maulana Husein',
            'position' => 'CEO',
            'personal_email' => 'maulinihisin1@crowddev.id'
        ]);
    }
}
