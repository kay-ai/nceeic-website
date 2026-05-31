<?php

namespace App\Filament\Resources\GrantApplicationResource\Pages;

use App\Filament\Resources\GrantApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrantApplication extends EditRecord
{
    protected static string $resource = GrantApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
