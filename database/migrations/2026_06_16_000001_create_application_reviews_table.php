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
        Schema::dropIfExists('application_reviews');
        Schema::create('application_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('grant_applications')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('restrict');
            $table->string('status')->default('pending'); // pending, recommended, conditional, not_recommended
            $table->unsignedTinyInteger('score_ownership')->default(0);
            $table->unsignedTinyInteger('score_beds')->default(0);
            $table->unsignedTinyInteger('score_icu_or')->default(0);
            $table->unsignedTinyInteger('score_revenue_mix')->default(0);
            $table->unsignedTinyInteger('score_energy_use')->default(0);
            $table->unsignedTinyInteger('score_iso')->default(0);
            $table->unsignedTinyInteger('score_cofinancing')->default(0);
            $table->unsignedTinyInteger('score_maintenance')->default(0);
            $table->unsignedSmallInteger('total_score')->default(0);
            $table->string('recommendation')->nullable(); // approved, conditional, rejected
            $table->longText('comments')->nullable();
            $table->boolean('site_visit_required')->default(false);
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index('application_id');
            $table->index('reviewer_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_reviews');
    }
};
