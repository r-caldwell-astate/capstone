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
        Schema::create('contract_version', function (Blueprint $table) {
            $table->id('version_id');
            $table->foreignId('contract_id')->constrained('contract', 'contract_id');
            $table->integer('version_number');
            $table->text('content');
            $table->date('created_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_version');
    }
};
