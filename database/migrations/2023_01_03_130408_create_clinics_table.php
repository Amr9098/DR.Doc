<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manger_id')->constrained('doctors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('assistant_id')->constrained('assistants')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('image')->nullable();
            $table->string('address');
            $table->integer('count')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinics');
    }
};
