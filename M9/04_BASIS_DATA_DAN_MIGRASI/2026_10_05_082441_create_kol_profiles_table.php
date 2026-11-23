<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kol_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('talent_category_id')->nullable()->constrained()->nullOnDelete();
            $table->text('bio')->nullable();
            $table->integer('followers')->default(0);
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->integer('total_jobs')->default(0);
            $table->integer('completed_jobs')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('kol_profiles'); }
};
