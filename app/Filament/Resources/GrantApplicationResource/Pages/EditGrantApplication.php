<?php

namespace App\Filament\Resources\GrantApplicationResource\Pages;

use App\Filament\Resources\GrantApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditGrantApplication extends EditRecord
{
    protected static string $resource = GrantApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('viewDocuments')
                ->label('View Documents')
                ->icon('heroicon-o-folder-open')
                ->url(fn () => route('filament.admin.resources.application-documents.index') . '?tableSearch=' . $this->record->application_id)
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Calculate total score from individual score components
        $totalScore = ($data['score_ownership'] ?? 0) +
                     ($data['score_beds'] ?? 0) +
                     ($data['score_icu_or'] ?? 0) +
                     ($data['score_revenue_mix'] ?? 0) +
                     ($data['score_energy_use'] ?? 0) +
                     ($data['score_iso'] ?? 0) +
                     ($data['score_cofinancing'] ?? 0) +
                     ($data['score_maintenance'] ?? 0);

        $data['total_score'] = $totalScore;
        $data['score_percentage'] = round(($totalScore / 100) * 100, 2);
        $data['is_qualified'] = $totalScore >= 70;
        $data['reviewed_by'] = auth()->id();

        return $data;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Application Updated')
            ->body('The application has been saved successfully.');
    }
}

