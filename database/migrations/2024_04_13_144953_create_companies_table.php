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
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('encrypt_view');
            $table->string('company_name');
            $table->string('work_field')->nullable();
            $table->string('country');
            $table->string('company_email');
            $table->string('company_description')->nullable();
            $table->string('name');
            $table->string('position');
            $table->string('personal_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};