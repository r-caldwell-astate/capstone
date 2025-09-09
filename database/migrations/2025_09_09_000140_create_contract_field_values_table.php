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
        Schema::create('contract_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('version_id')->constrained('contract_versions', 'id')->cascadeOnDelete();
            $table->foreignId('field_id')->constrained('contract_fields', 'id')->cascadeOnDelete();
            $table->text('value')->nullable();
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
