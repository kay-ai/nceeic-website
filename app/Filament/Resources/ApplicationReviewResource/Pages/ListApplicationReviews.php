<?php

namespace App\Filament\Resources\ApplicationReviewResource\Pages;

use App\Filament\Resources\ApplicationReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApplicationReviews extends ListRecords
{
    protected static string $resource = ApplicationReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
