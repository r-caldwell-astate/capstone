<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('contract', function (Blueprint $table) {
        //     $table->id('contract_id');
        //     $table->string('recipient_name');
        //     $table->string('recipient_email');
        //     $table->date('sent_date')->nullable();
        //     $table->date('signed_date')->nullable();
        //     $table->foreignId('user_id')->constrained('users');
        //     $table->foreignId('status_id')->constrained('contract_status', 'status_id');
        //     $table->timestamps();
        Schema::create('contracts', function (Blueprint $table) {
            $table->id(); // BIGINT unsigned 'id'
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete(); // optional
            $table->string('title');
            $table->enum('status', ['draft','sent','signed'])->default('draft'); // or use a statuses FK if you have that table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract');
    }
};
