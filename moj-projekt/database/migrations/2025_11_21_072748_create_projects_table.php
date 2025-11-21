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
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('naziv_projekta');
        $table->text('opis_projekta')->nullable();
        $table->decimal('cijena_projekta', 10, 2)->nullable();
        $table->text('obavljeni_poslovi')->nullable();
        $table->date('datum_pocetka')->nullable();
        $table->date('datum_zavrsetka')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
