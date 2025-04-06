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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->double('value');
            $table->unsignedBigInteger('user_payer_id');
            $table->unsignedBigInteger('user_payee_id');
            $table->uuid('token');
            $table->softDeletes();

            $table->foreign('user_payer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_payee_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
