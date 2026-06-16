<?php

namespace App\Filament\Pages;

use App\Models\GrantApplication;
use Filament\Pages\Page;
use Filament\Forms\Components\Section;

class ApplicationDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    protected static ?string $navigationGroup = 'Grant Management';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.application-dashboard';
    protected static ?string $title = 'Dashboard';

    public array $stats = [];
    public array $recentApplications = [];
    public array $qualifiedApplications = [];
    public array $statusSummary = [];
    public int $totalApplications = 0;
    public string $searchRecent = '';
    public string $searchQualified = '';

    public function mount(): void
    {
        $this->loadDashboardData();
    }

    private function loadDashboardData(): void
    {
        // Single query for all stats and status counts
        $statsData = GrantApplication::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = "submitted" THEN 1 ELSE 0 END) as submitted,
            SUM(CASE WHEN status = "under_review" THEN 1 ELSE 0 END) as under_review,
            SUM(CASE WHEN status = "shortlisted" THEN 1 ELSE 0 END) as shortlisted,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN status = "site_visit_scheduled" THEN 1 ELSE 0 END) as site_visit_scheduled,
            SUM(CASE WHEN status = "draft" THEN 1 ELSE 0 END) as draft,
            SUM(CASE WHEN is_qualified = true THEN 1 ELSE 0 END) as qualified,
            SUM(CASE WHEN site_visit_required = true THEN 1 ELSE 0 END) as visits_required
        ')->first();

        $this->totalApplications = (int) $statsData->total;

        $this->stats = [
            ['label' => 'Total Applications', 'value' => $this->totalApplications, 'color' => 'info'],
            ['label' => 'Submitted', 'value' => (int) $statsData->submitted, 'color' => 'blue'],
            ['label' => 'Under Review', 'value' => (int) $statsData->under_review, 'color' => 'yellow'],
            ['label' => 'Shortlisted', 'value' => (int) $statsData->shortlisted, 'color' => 'warning'],
            ['label' => 'Approved', 'value' => (int) $statsData->approved, 'color' => 'success'],
            ['label' => 'Rejected', 'value' => (int) $statsData->rejected, 'color' => 'danger'],
            ['label' => 'Qualified (≥70%)', 'value' => (int) $statsData->qualified, 'color' => 'success'],
            ['label' => 'Site Visits Required', 'value' => (int) $statsData->visits_required, 'color' => 'warning'],
        ];

        // Query with eager loading
        $this->recentApplications = GrantApplication::with('hospital')
            ->latest('submitted_at')
            ->limit(10)
            ->get()
            ->map(fn ($app) => [
                'id' => $app->id,
                'application_id' => $app->application_id,
                'hospital_name' => $app->hospital?->hospital_name,
                'status' => $app->status,
            ])
            ->toArray();

        $this->qualifiedApplications = GrantApplication::with('hospital')
            ->where('is_qualified', true)
            ->latest('score_percentage')
            ->limit(10)
            ->get()
            ->map(fn ($app) => [
                'id' => $app->id,
                'hospital_name' => $app->hospital?->hospital_name,
                'score_percentage' => $app->score_percentage,
            ])
            ->toArray();

        // Status summary with pre-calculated percentages
        $statuses = ['submitted', 'under_review', 'shortlisted', 'approved', 'rejected', 'site_visit_scheduled', 'draft'];

        $this->statusSummary = collect($statuses)->map(function ($status) use ($statsData) {
            $count = match ($status) {
                'submitted' => (int) $statsData->submitted,
                'under_review' => (int) $statsData->under_review,
                'shortlisted' => (int) $statsData->shortlisted,
                'approved' => (int) $statsData->approved,
                'rejected' => (int) $statsData->rejected,
                'site_visit_scheduled' => (int) $statsData->site_visit_scheduled,
                'draft' => (int) $statsData->draft,
                default => 0,
            };

            $percentage = $this->totalApplications > 0 ? round(($count / $this->totalApplications) * 100, 1) : 0;

            return [
                'status' => $status,
                'count' => $count,
                'percentage' => $percentage,
            ];
        })->toArray();
    }

    public function getStats(): array
    {
        return $this->stats;
    }
}
