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
        // Ensure order so IDs are predictable (1=draft, 2=sent, 3=pending, 4=signed)
        ContractStatus::query()->delete();

        ContractStatus::create(['status_name' => 'draft']);
        ContractStatus::create(['status_name' => 'sent']);
        ContractStatus::create(['status_name' => 'pending']);
        ContractStatus::create(['status_name' => 'signed']); 
    }
}