<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();

            $table->string('hospital_name');
            $table->string('cac_number')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->enum('ownership_type', ['public', 'private']);
            $table->unsignedInteger('number_of_beds');
            $table->decimal('insurance_revenue_pct', 5, 2)->comment('% revenue from health insurance');

            $table->boolean('is_eligible')->default(false);
            $table->json('ineligibility_reasons')->nullable();

            $table->enum('application_step', ['step1', 'step2', 'step3', 'submitted'])->default('step1');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
