<?php
// app/Services/ScoringService.php

namespace App\Services;

use App\Models\GrantApplication;

class ScoringService
{
    // Max possible score = 100
    const MAX_SCORE = 100;
    const PASS_THRESHOLD = 70; // 70%

    public function score(GrantApplication $application): GrantApplication
    {
        $scores = [
            'score_ownership'   => $this->scoreOwnership($application),
            'score_beds'        => $this->scoreBeds($application),
            'score_icu_or'      => $this->scoreIcuOr($application),
            'score_revenue_mix' => $this->scoreRevenueMix($application),
            'score_energy_use'  => $this->scoreEnergyUse($application),
            'score_iso'         => $this->scoreIso($application),
            'score_cofinancing' => $this->scoreCofinancing($application),
            'score_maintenance' => $this->scoreMaintenance($application),
        ];

        $total = array_sum($scores);
        $percentage = round(($total / self::MAX_SCORE) * 100, 2);

        $application->fill([
            ...$scores,
            'total_score'      => $total,
            'score_percentage' => $percentage,
            'is_qualified'     => $percentage >= self::PASS_THRESHOLD,
        ]);

        $application->save();

        return $application;
    }

    // ── Scoring Criteria ──────────────────────────────────────

    /** Private = 15, Public = 10 | Max: 15 */
    private function scoreOwnership(GrantApplication $app): int
    {
        return $app->ownership_type === 'private' ? 15 : 10;
    }

    /** ≥ 50 beds = 10 | Max: 10 */
    private function scoreBeds(GrantApplication $app): int
    {
        return $app->number_of_beds >= 50 ? 10 : 0;
    }

    /** ICU + OR combined ≥ 30 = 15 | Max: 15 */
    private function scoreIcuOr(GrantApplication $app): int
    {
        $combined = ($app->number_of_icu_beds ?? 0) + ($app->number_of_active_ors ?? 0);
        return $combined >= 30 ? 15 : ($combined >= 15 ? 8 : 0);
    }

    /** ≥ 20% insurance revenue = 10 | Max: 10 */
    private function scoreRevenueMix(GrantApplication $app): int
    {
        $pct = $app->insurance_revenue_pct ?? 0;
        if ($app->total_revenue > 0 && $app->revenue_from_insurance > 0) {
            $pct = ($app->revenue_from_insurance / $app->total_revenue) * 100;
            // update the calculated field
            $app->insurance_revenue_pct = round($pct, 2);
        }
        return $pct >= 20 ? 10 : 0;
    }

    /**
     * Energy use meets threshold = 15 | Max: 15
     * Threshold: monthly consumption > 0 AND diesel consumption reported
     */
    private function scoreEnergyUse(GrantApplication $app): int
    {
        $hasEnergyData = $app->monthly_energy_consumption_kwh > 0
            && $app->monthly_diesel_consumption > 0;
        return $hasEnergyData ? 15 : 0;
    }

    /** Full ISO = 15, Partial = 10, None = 0 | Max: 15 */
    private function scoreIso(GrantApplication $app): int
    {
        return match($app->iso_compliance) {
            'full'    => 15,
            'partial' => 10,
            default   => 0,
        };
    }

    /** Co-financing ≥ 10% = 10 | Max: 10 */
    private function scoreCofinancing(GrantApplication $app): int
    {
        return ($app->cofinancing_commitment_pct ?? 0) >= 10 ? 10 : 0;
    }

    /** Has maintenance reserve = 10 | Max: 10 */
    private function scoreMaintenance(GrantApplication $app): int
    {
        return $app->has_maintenance_reserve ? 10 : 0;
    }

    public function getBreakdown(GrantApplication $app): array
    {
        return [
            ['criterion' => 'Ownership Type',        'score' => $app->score_ownership,   'max' => 15],
            ['criterion' => 'Bed Capacity',           'score' => $app->score_beds,         'max' => 10],
            ['criterion' => 'ICU / OR Capacity',      'score' => $app->score_icu_or,       'max' => 15],
            ['criterion' => 'Revenue Mix',            'score' => $app->score_revenue_mix,  'max' => 10],
            ['criterion' => 'Energy Use Data',        'score' => $app->score_energy_use,   'max' => 15],
            ['criterion' => 'ISO 7101:2023 Compliance','score' => $app->score_iso,         'max' => 15],
            ['criterion' => 'Co-financing Commitment','score' => $app->score_cofinancing,  'max' => 10],
            ['criterion' => 'Maintenance Reserve',    'score' => $app->score_maintenance,  'max' => 10],
            ['criterion' => 'TOTAL',                  'score' => $app->total_score,        'max' => 100],
        ];
    }
}
