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
        Schema::create('contract_field_value', function (Blueprint $table) {
            $table->id('field_value_id');
            $table->foreignId('contract_id')->constrained('contract', 'contract_id');
            $table->foreignId('version_id')->constrained('contract_version', 'version_id');
            $table->foreignId('field_id')->constrained('contract_field', 'field_id');
            $table->string('field_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_field_value');
    }
};
