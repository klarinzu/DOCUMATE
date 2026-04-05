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
        Schema::create('template_instructions', function (Blueprint $table) {
            $table->id('instruction_id');

            $table->unsignedBigInteger('version_id');

            $table->integer('step_number');
            $table->text('description');

            $table->timestamps();

            // FK
            $table->foreign('version_id')
                ->references('version_id')->on('template_versions')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_instructions');
    }
};
