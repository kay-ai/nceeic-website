<?php

namespace App\Models;

use App\Notifications\HospitalVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hospital extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guard = 'hospital';

    protected $fillable = [
        'hospital_name',
        'cac_number',
        'email',
        'phone',
        'password',
        'ownership_type',
        'number_of_beds',
        'insurance_revenue_pct',
        'is_eligible',
        'ineligibility_reasons',
        'application_step',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'     => 'datetime',
        'password'              => 'hashed',
        'is_eligible'           => 'boolean',
        'ineligibility_reasons' => 'array',
    ];

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new HospitalVerifyEmail);
    }

    public function application(): HasOne
    {
        return $this->hasOne(GrantApplication::class);
    }

    public function checkEligibility(): array
    {
        $reasons = [];

        if ($this->number_of_beds < 50) {
            $reasons[] = 'Hospital must have a minimum of 50 beds (you entered ' . $this->number_of_beds . ').';
        }

        if ($this->insurance_revenue_pct < 20) {
            $reasons[] = 'At least 20% of revenue must come from health insurance (you entered ' . $this->insurance_revenue_pct . '%).';
        }

        return $reasons;
    }

    // ── Helpers ───────────────────────────────────────────────
    public function getStepNumberAttribute(): int
    {
        return match($this->application_step) {
            'step1'     => 1,
            'step2'     => 2,
            'step3'     => 3,
            'submitted' => 4,
            default     => 1,
        };
    }
}
