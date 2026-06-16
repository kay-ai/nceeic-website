<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationReview extends Model
{
    protected $fillable = [
        'application_id',
        'reviewer_id',
        'status',
        'score_ownership',
        'score_beds',
        'score_icu_or',
        'score_revenue_mix',
        'score_energy_use',
        'score_iso',
        'score_cofinancing',
        'score_maintenance',
        'total_score',
        'recommendation',
        'comments',
        'site_visit_required',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(GrantApplication::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function getTotalScore(): int
    {
        return intval(
            ($this->score_ownership ?? 0) +
            ($this->score_beds ?? 0) +
            ($this->score_icu_or ?? 0) +
            ($this->score_revenue_mix ?? 0) +
            ($this->score_energy_use ?? 0) +
            ($this->score_iso ?? 0) +
            ($this->score_cofinancing ?? 0) +
            ($this->score_maintenance ?? 0)
        );
    }

    public function getScorePercentage(): float
    {
        return round(($this->getTotalScore() / 100) * 100, 2);
    }

    public function isQualified(): bool
    {
        return $this->getScorePercentage() >= 70;
    }
}

