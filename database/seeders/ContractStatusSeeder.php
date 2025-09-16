<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractStatus;

class ContractStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContractStatus::create(['status_name' => 'Draft']);      // This will get ID = 1
        ContractStatus::create(['status_name' => 'Sent']);       // This will get ID = 2
        ContractStatus::create(['status_name' => 'Signed']);     // This will get ID = 3
        ContractStatus::create(['status_name' => 'Archived']);   // This will get ID = 4
    }
}