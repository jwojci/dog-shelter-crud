<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('dogs');

        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('breed')->nullable(false);
            $table->string('age')->nullable(false);
            $table->enum('sex', ['male', 'female'])->nullable(false);
            $table->boolean('adopted')->default(false)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dogs');
    }
};
