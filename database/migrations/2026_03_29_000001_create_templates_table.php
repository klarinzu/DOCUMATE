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
        Schema::create('templates', function (Blueprint $table) {
            $table->id('template_id');
            $table->string('name');
            $table->unsignedBigInteger('current_version_id')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active'); // ✅ added

            $table->timestamps();

            // FK
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // ⚠️ do NOT add FK for current_version_id yet (circular issue)
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
