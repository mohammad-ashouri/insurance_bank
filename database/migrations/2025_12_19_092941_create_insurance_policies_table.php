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
        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policyholder_id');
            $table->foreign('policyholder_id')->references('id')->on('policyholders');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('policyholders');
            $table->unsignedBigInteger('insurance_type_id');
            $table->foreign('insurance_type_id')->references('id')->on('insurance_types');
            $table->date('starts_at')->nullable();
            $table->date('ends_at');
            $table->string('insurance_policy_number')->nullable();
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_policies');
    }
};
