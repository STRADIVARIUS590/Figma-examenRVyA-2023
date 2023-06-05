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
        Schema::create('figures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('index')->nullable();
            $table->integer('x')->nullable();
            $table->integer('y')->nullable();
            $table->integer('h')->nullable();
            $table->integer('w')->nullable();
            $table->integer('opacity')->nullable();
            $table->integer('border_size')->nullable();
            $table->integer('border_opacity')->nullable();
            $table->integer('radius_corner')->nullable();
            $table->integer('font_size')->nullable();
            $table->string('type')->nullable();
            $table->string('color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('text')->nullable();
            $table->boolean('visible')->default(true);
            $table->integer('layer')->nullable();
            $table->foreignId('draw_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('figures');
    }
};
