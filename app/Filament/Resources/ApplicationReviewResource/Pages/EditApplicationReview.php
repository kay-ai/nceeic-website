<?php

namespace App\Filament\Resources\ApplicationReviewResource\Pages;

use App\Filament\Resources\ApplicationReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApplicationReview extends EditRecord
{
    protected static string $resource = ApplicationReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['total_score'] = ($data['score_ownership'] ?? 0) +
                               ($data['score_beds'] ?? 0) +
                               ($data['score_icu_or'] ?? 0) +
                               ($data['score_revenue_mix'] ?? 0) +
                               ($data['score_energy_use'] ?? 0) +
                               ($data['score_iso'] ?? 0) +
                               ($data['score_cofinancing'] ?? 0) +
                               ($data['score_maintenance'] ?? 0);

        return $data;
    }
}
