<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_versions', function (Blueprint $table) {
            $table->id(); // BIGINT unsigned
            $table->foreignId('contract_id')->constrained('contracts')->cascadeOnDelete();
            $table->unsignedInteger('version_number')->default(1);
            $table->json('snapshot')->nullable(); // optional: frozen text/fields
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_versions');
    }
};