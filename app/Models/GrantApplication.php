<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GrantApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_id', 'hospital_id',

        'hospital_name', 'hospital_type', 'year_established', 'ownership_type',
        'facility_ownership', 'state', 'lga', 'address',
        'number_of_beds', 'number_of_icu_beds', 'number_of_active_ors',

        'total_revenue', 'revenue_from_cash', 'revenue_from_insurance', 'insurance_revenue_pct',

        'grid_connectivity', 'monthly_diesel_consumption', 'monthly_energy_bill', 'monthly_energy_consumption_kwh',

        'iso_compliance', 'management_practices', 'maintenance_policies',

        'cofinancing_commitment_pct', 'cofinancing_source', 'has_maintenance_reserve', 'maintenance_reserve_amount',

        'additional_comments',

        'score_ownership', 'score_beds', 'score_icu_or', 'score_revenue_mix',
        'score_energy_use', 'score_iso', 'score_cofinancing', 'score_maintenance',
        'total_score', 'score_percentage', 'is_qualified',

        'status', 'admin_score_override', 'admin_notes',
        'site_visit_required', 'site_visit_date', 'submitted_at', 'reviewed_by',
    ];

    protected $casts = [
        'is_qualified'         => 'boolean',
        'has_maintenance_reserve' => 'boolean',
        'site_visit_required'  => 'boolean',
        'submitted_at'         => 'datetime',
        'site_visit_date'      => 'datetime',
        'score_percentage'     => 'decimal:2',
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public static function generateApplicationId(): string
    {
        $year = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'HSP-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'draft'                  => 'gray',
            'submitted'              => 'blue',
            'under_review'           => 'yellow',
            'shortlisted'            => 'green',
            'rejected'               => 'red',
            'site_visit_scheduled'   => 'purple',
            'approved'               => 'green',
            default                  => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft'                  => 'Draft',
            'submitted'              => 'Submitted',
            'under_review'           => 'Under Review',
            'shortlisted'            => 'Shortlisted',
            'rejected'               => 'Rejected',
            'site_visit_scheduled'   => 'Site Visit Scheduled',
            'approved'               => 'Approved',
            default                  => 'Unknown',
        };
    }

    public function getDocumentStatusAttribute(): array
    {
        $required = [
            'financial_statements',
            'energy_consumption_report',
            'fuel_expenditure_report',
            'iso_certification',
            'management_certifications',
            'cofinancing_proof',
        ];

        $uploaded = $this->documents->pluck('document_type')->toArray();

        return array_map(fn($type) => [
            'type'     => $type,
            'label'    => ucwords(str_replace('_', ' ', $type)),
            'uploaded' => in_array($type, $uploaded),
        ], $required);
    }
}
