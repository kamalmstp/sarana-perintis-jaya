<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::insert([
            ['code' => '1100', 'name' => 'Kas', 'type' => 'asset'],
            ['code' => '1200', 'name' => 'Piutang Usaha', 'type' => 'asset'],
            ['code' => '4100', 'name' => 'Pendapatan Ekspedisi', 'type' => 'revenue'],
            ['code' => '5100', 'name' => 'Biaya Uang Sangu', 'type' => 'expense'],
            ['code' => '5200', 'name' => 'Biaya Operasional', 'type' => 'expense'],
        ]);
    }
}
