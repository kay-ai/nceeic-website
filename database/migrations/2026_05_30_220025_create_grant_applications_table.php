<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grant_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_id')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();

            $table->string('hospital_name');
            $table->string('hospital_type')->nullable();
            $table->year('year_established')->nullable();
            $table->enum('ownership_type', ['public', 'private']);
            $table->enum('facility_ownership', ['owned', 'leased']);
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('number_of_beds');
            $table->unsignedInteger('number_of_icu_beds')->default(0);
            $table->unsignedInteger('number_of_active_ors')->default(0);

            $table->decimal('total_revenue', 15, 2)->nullable();
            $table->decimal('revenue_from_cash', 15, 2)->nullable();
            $table->decimal('revenue_from_insurance', 15, 2)->nullable();
            $table->decimal('insurance_revenue_pct', 5, 2)->nullable();

            $table->enum('grid_connectivity', ['connected', 'not_connected', 'partial']);
            $table->decimal('monthly_diesel_consumption', 10, 2)->nullable()->comment('Litres');
            $table->decimal('monthly_energy_bill', 12, 2)->nullable()->comment('NGN');
            $table->decimal('monthly_energy_consumption_kwh', 10, 2)->nullable();

            $table->enum('iso_compliance', ['full', 'partial', 'none'])->default('none');
            $table->text('management_practices')->nullable();
            $table->text('maintenance_policies')->nullable();

            $table->decimal('cofinancing_commitment_pct', 5, 2)->nullable()->comment('% of project cost');
            $table->string('cofinancing_source')->nullable();
            $table->boolean('has_maintenance_reserve')->default(false);
            $table->decimal('maintenance_reserve_amount', 12, 2)->nullable();

            $table->text('additional_comments')->nullable();

            $table->unsignedInteger('score_ownership')->default(0);
            $table->unsignedInteger('score_beds')->default(0);
            $table->unsignedInteger('score_icu_or')->default(0);
            $table->unsignedInteger('score_revenue_mix')->default(0);
            $table->unsignedInteger('score_energy_use')->default(0);
            $table->unsignedInteger('score_iso')->default(0);
            $table->unsignedInteger('score_cofinancing')->default(0);
            $table->unsignedInteger('score_maintenance')->default(0);
            $table->unsignedInteger('total_score')->default(0);
            $table->decimal('score_percentage', 5, 2)->default(0);
            $table->boolean('is_qualified')->default(false);

            $table->enum('status', [
                'draft',
                'submitted',
                'under_review',
                'shortlisted',
                'rejected',
                'site_visit_scheduled',
                'approved',
            ])->default('draft');

            // Admin fields
            $table->unsignedInteger('admin_score_override')->nullable();
            $table->text('admin_notes')->nullable();
            $table->boolean('site_visit_required')->default(false);
            $table->timestamp('site_visit_date')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grant_applications');
    }
};
