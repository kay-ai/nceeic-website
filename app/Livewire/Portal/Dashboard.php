<?php

namespace App\Livewire\Portal;

use App\Services\ScoringService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $hospital    = Auth::guard('hospital')->user();
        $application = $hospital->application()->with('documents')->first();
        $breakdown   = null;

        if ($application && $application->total_score > 0) {
            $breakdown = app(ScoringService::class)->getBreakdown($application);
        }

        return view('livewire.portal.dashboard', compact('hospital', 'application', 'breakdown'))
            ->layout('layouts.portal');
    }
}
