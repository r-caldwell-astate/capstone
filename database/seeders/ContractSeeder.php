<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Contract;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        // Grab any existing user (you create one in DatabaseSeeder)
        $user = User::first();
        if (!$user) {
            $this->command?->warn('No users found; skipping ContractSeeder.');
            return;
        }

        // Helper to get status_id by name from contract_status
        $statusId = fn(string $name) =>
            DB::table('contract_status')->where('status_name', $name)->value('status_id');

        // Optional: wipe for a clean dev slate
        // Contract::query()->delete();

        Contract::insert([
            [
                'recipient_name'  => 'Alice Smith',
                'recipient_email' => 'alice@example.com',
                // Users table may use 'id' (Laravel default) or 'user_id' (custom)
                'user_id'         => $user->id ?? $user->user_id,
                'status_id'       => $statusId('draft'),
                'sent_date'       => now()->subDays(2),
                'signed_date'     => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'recipient_name'  => 'Bob Johnson',
                'recipient_email' => 'bob@example.com',
                'user_id'         => $user->id ?? $user->user_id,
                'status_id'       => $statusId('sent'),
                'sent_date'       => now()->subDay(),
                'signed_date'     => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'recipient_name'  => 'Charlie Doe',
                'recipient_email' => 'charlie@example.com',
                'user_id'         => $user->id ?? $user->user_id,
                'status_id'       => $statusId('signed'),
                'sent_date'       => now()->subDays(5),
                'signed_date'     => now()->subDays(3),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}