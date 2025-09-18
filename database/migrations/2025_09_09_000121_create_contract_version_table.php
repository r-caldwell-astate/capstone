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
        Schema::create('contract_versions', function (Blueprint $table) {
             $table->bigIncrements('version_id');
            $table->unsignedBigInteger('contract_id');

            $table->unsignedInteger('version_number')->default(1);
            $table->longText('content')->nullable();
            $table->timestamp('created_date')->useCurrent();

            // FK to contract (singular table per your model)
            $table->foreign('contract_id')
                  ->references('contract_id')
                  ->on('contract')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_versions');
    }
};
