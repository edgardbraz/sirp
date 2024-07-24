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
        Schema::create('art_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->boolean('payment_made')->default(false);
            $table->unsignedBigInteger('user_id'); // Adiciona a coluna user_id
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('art_requests', function (Blueprint $table) {
            // Remove a chave estrangeira antes de remover a tabela
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('art_requests');
    }
};
