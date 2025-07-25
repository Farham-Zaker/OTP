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
        Schema::create('O_T_Ps', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("phone_number");
            $table->string("otp");
            $table->string("expired_at");
            $table->boolean("is_used");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('O_T_Ps');
    }
};
