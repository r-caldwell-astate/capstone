<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractField;

class ContractFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Idempotent-ish: cear if we wanna consistent dev data
     * ContractField::query()->delete();
     */
    public function run(): void
    {
        ContractField::firstOrCreate(['field_name' => 'Client Name']);
        ContractField::firstOrCreate(['field_name' => 'Company Name']);
        ContractField::firstOrCreate(['field_name' => 'Signature']);
        ContractField::firstOrCreate(['field_name' => 'Date']);
    }
}