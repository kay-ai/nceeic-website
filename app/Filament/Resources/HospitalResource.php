<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HospitalResource\Pages;
use App\Models\Hospital;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class HospitalResource extends Resource
{
    protected static ?string $model = Hospital::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Grant Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Account Details')
                ->schema([
                    Forms\Components\TextInput::make('hospital_name')->required(),
                    Forms\Components\TextInput::make('cac_number')->required()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('phone')->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Pre-eligibility Data')
                ->schema([
                    Forms\Components\Select::make('ownership_type')
                        ->options(['public' => 'Public', 'private' => 'Private'])
                        ->required(),
                    Forms\Components\TextInput::make('number_of_beds')->numeric()->required(),
                    Forms\Components\TextInput::make('insurance_revenue_pct')
                        ->numeric()->suffix('%')->required(),
                    Forms\Components\Toggle::make('is_eligible')->label('Eligible')->disabled(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Application Status')
                ->schema([
                    Forms\Components\Select::make('application_step')
                        ->options([
                            'step1'     => 'Step 1 — Account created',
                            'step2'     => 'Step 2 — Application form',
                            'step3'     => 'Step 3 — Document upload',
                            'submitted' => 'Submitted',
                        ])
                        ->disabled(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hospital_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\BadgeColumn::make('ownership_type')
                    ->colors(['info' => 'private', 'success' => 'public']),
                Tables\Columns\TextColumn::make('number_of_beds')->sortable(),
                Tables\Columns\TextColumn::make('insurance_revenue_pct')
                    ->label('Insurance %')
                    ->formatStateUsing(fn ($state) => $state . '%'),
                Tables\Columns\IconColumn::make('is_eligible')
                    ->label('Eligible')->boolean(),
                Tables\Columns\BadgeColumn::make('application_step')
                    ->label('Step')
                    ->colors([
                        'gray'   => 'step1',
                        'blue'   => 'step2',
                        'yellow' => 'step3',
                        'green'  => 'submitted',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')->date('d M Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('ownership_type')
                    ->options(['public' => 'Public', 'private' => 'Private']),
                TernaryFilter::make('is_eligible')->label('Eligible'),
                SelectFilter::make('application_step')
                    ->options([
                        'step1'     => 'Step 1',
                        'step2'     => 'Step 2',
                        'step3'     => 'Step 3',
                        'submitted' => 'Submitted',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view_application')
                    ->label('View Application')
                    ->icon('heroicon-o-document-text')
                    ->url(fn ($record) => $record->application
                        ? GrantApplicationResource::getUrl('edit', ['record' => $record->application])
                        : null)
                    ->visible(fn ($record) => $record->application !== null),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHospitals::route('/'),
            'create' => Pages\CreateHospital::route('/create'),
            'edit'   => Pages\EditHospital::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count() ?: null;
    }
}
