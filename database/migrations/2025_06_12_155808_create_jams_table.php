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
        Schema::create('jams', function (Blueprint $table) {
            $table->bigInteger("id_jam", 1)->primary();
            $table->bigInteger("id_user")->nullable();
            $table->string("name");
            $table->string("serialNumber");
            $table->string("imageUrl");
            $table->timestamps();
        
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jams');
    }
};
