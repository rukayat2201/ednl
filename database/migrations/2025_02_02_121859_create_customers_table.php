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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('bvn');
            $table->string('telephone');
            $table->string('dob');
            $table->string('residential_address');
            $table->string('state');
            $table->string('bank_code');
            $table->string('accountnumber');
            $table->string('company_id');
            $table->string('email');
            $table->string('city');
            $table->string('country');
            $table->string('id_card')->nullable();
            $table->string('voters_card')->nullable();
            $table->string('drivers_license')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
