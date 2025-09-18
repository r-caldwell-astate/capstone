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
            $table->bigIncrements('id');

            $table->unsignedBigInteger('contract_id'); // FK to contract
            $table->unsignedBigInteger('version_id');  // FK to contract_versions
            $table->unsignedBigInteger('field_id');    // FK to contract_field

            $table->text('field_value')->nullable();
            $table->timestamps();

            $table->foreign('contract_id')
                  ->references('contract_id')
                  ->on('contract')
                  ->onDelete('cascade');

            $table->foreign('version_id')
                  ->references('version_id')
                  ->on('contract_versions')   // <-- plural here
                  ->onDelete('cascade');

            $table->foreign('field_id')
                  ->references('field_id')
                  ->on('contract_field')
                  ->onDelete('cascade');
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
