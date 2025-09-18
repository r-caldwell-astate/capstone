<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractField;

class ContractFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContractField::create(['field_name' => 'Client Name']);
        ContractField::create(['field_name' => 'Company Name']);
        ContractField::create(['field_name' => 'Signature']);
        ContractField::create(['field_name' => 'Date']);
    }
}