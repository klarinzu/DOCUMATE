<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('template_versions', function (Blueprint $table) {
            $table->id('version_id');

            $table->unsignedBigInteger('template_id');

            $table->string('image_path');
            $table->enum('document_size', ['A4', 'Letter', 'Legal', 'A3', 'Custom']);
            $table->enum('orientation', ['portrait', 'landscape']);
            $table->integer('custom_width')->nullable();
            $table->integer('custom_height')->nullable();

            $table->integer('version_number')->default(1); // ✅ added
            $table->boolean('is_active')->default(true);   // ✅ optional but useful

            $table->timestamps();

            // FK
            $table->foreign('template_id')
                ->references('template_id')->on('templates')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_versions');
    }
};
