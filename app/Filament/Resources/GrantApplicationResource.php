<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GrantApplicationResource\Pages;
use App\Models\GrantApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class GrantApplicationResource extends Resource
{
    protected static ?string $model = GrantApplication::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Grant Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'application_id';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Application Overview')
                ->schema([
                    Forms\Components\TextInput::make('application_id')->disabled(),
                    Forms\Components\TextInput::make('hospital.hospital_name')->disabled()->label('Hospital'),
                    Forms\Components\Select::make('status')
                        ->options([
                            'draft'                => 'Draft',
                            'submitted'            => 'Submitted',
                            'under_review'         => 'Under Review',
                            'shortlisted'          => 'Shortlisted',
                            'rejected'             => 'Rejected',
                            'site_visit_scheduled' => 'Site Visit Scheduled',
                            'approved'             => 'Approved',
                        ])
                        ->required(),
                    Forms\Components\DateTimePicker::make('submitted_at')->disabled(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Scoring')
                ->schema([
                    Forms\Components\TextInput::make('total_score')->disabled()->suffix('/ 100'),
                    Forms\Components\TextInput::make('score_percentage')->disabled()->suffix('%'),
                    Forms\Components\Toggle::make('is_qualified')->disabled()->label('Qualified (≥70%)'),
                    Forms\Components\TextInput::make('admin_score_override')
                        ->numeric()->minValue(0)->maxValue(100)
                        ->label('Admin Score Override')
                        ->helperText('Override the calculated score if needed.'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Score Breakdown (Read-only)')
                ->schema([
                    Forms\Components\TextInput::make('score_ownership')->disabled()->label('Ownership (max 15)'),
                    Forms\Components\TextInput::make('score_beds')->disabled()->label('Beds (max 10)'),
                    Forms\Components\TextInput::make('score_icu_or')->disabled()->label('ICU/OR (max 15)'),
                    Forms\Components\TextInput::make('score_revenue_mix')->disabled()->label('Revenue Mix (max 10)'),
                    Forms\Components\TextInput::make('score_energy_use')->disabled()->label('Energy Use (max 15)'),
                    Forms\Components\TextInput::make('score_iso')->disabled()->label('ISO (max 15)'),
                    Forms\Components\TextInput::make('score_cofinancing')->disabled()->label('Co-financing (max 10)'),
                    Forms\Components\TextInput::make('score_maintenance')->disabled()->label('Maintenance (max 10)'),
                ])
                ->columns(4)
                ->collapsed(),

            Forms\Components\Section::make('Admin Review')
                ->schema([
                    Forms\Components\Textarea::make('admin_notes')->rows(4)->label('Internal Notes'),
                    Forms\Components\Toggle::make('site_visit_required'),
                    Forms\Components\DateTimePicker::make('site_visit_date')
                        ->visible(fn ($get) => $get('site_visit_required')),
                ])
                ->columns(2),

            // Read-only application data sections
            Forms\Components\Section::make('A. Hospital Information')
                ->schema([
                    Forms\Components\TextInput::make('hospital_type')->disabled(),
                    Forms\Components\TextInput::make('year_established')->disabled(),
                    Forms\Components\TextInput::make('ownership_type')->disabled(),
                    Forms\Components\TextInput::make('facility_ownership')->disabled(),
                    Forms\Components\TextInput::make('state')->disabled(),
                    Forms\Components\TextInput::make('lga')->disabled(),
                    Forms\Components\TextInput::make('address')->disabled()->columnSpanFull(),
                    Forms\Components\TextInput::make('number_of_beds')->disabled(),
                    Forms\Components\TextInput::make('number_of_icu_beds')->disabled(),
                    Forms\Components\TextInput::make('number_of_active_ors')->disabled(),
                ])
                ->columns(3)
                ->collapsed(),

            Forms\Components\Section::make('B. Revenue Information')
                ->schema([
                    Forms\Components\TextInput::make('total_revenue')->disabled()->prefix('₦'),
                    Forms\Components\TextInput::make('revenue_from_cash')->disabled()->prefix('₦'),
                    Forms\Components\TextInput::make('revenue_from_insurance')->disabled()->prefix('₦'),
                    Forms\Components\TextInput::make('insurance_revenue_pct')->disabled()->suffix('%'),
                ])
                ->columns(2)
                ->collapsed(),

            Forms\Components\Section::make('C. Energy Consumption')
                ->schema([
                    Forms\Components\TextInput::make('grid_connectivity')->disabled(),
                    Forms\Components\TextInput::make('monthly_diesel_consumption')->disabled()->suffix('L'),
                    Forms\Components\TextInput::make('monthly_energy_bill')->disabled()->prefix('₦'),
                    Forms\Components\TextInput::make('monthly_energy_consumption_kwh')->disabled()->suffix('kWh'),
                ])
                ->columns(2)
                ->collapsed(),

            Forms\Components\Section::make('D. Management & Compliance')
                ->schema([
                    Forms\Components\TextInput::make('iso_compliance')->disabled(),
                    Forms\Components\Textarea::make('management_practices')->disabled()->rows(3),
                    Forms\Components\Textarea::make('maintenance_policies')->disabled()->rows(3),
                ])
                ->collapsed(),

            Forms\Components\Section::make('E. Financial Capacity')
                ->schema([
                    Forms\Components\TextInput::make('cofinancing_commitment_pct')->disabled()->suffix('%'),
                    Forms\Components\TextInput::make('cofinancing_source')->disabled(),
                    Forms\Components\Toggle::make('has_maintenance_reserve')->disabled(),
                    Forms\Components\TextInput::make('maintenance_reserve_amount')->disabled()->prefix('₦'),
                ])
                ->columns(2)
                ->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application_id')
                    ->searchable()->sortable()->copyable(),

                Tables\Columns\TextColumn::make('hospital.hospital_name')
                    ->searchable()->sortable()->label('Hospital'),

                Tables\Columns\TextColumn::make('hospital.ownership_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn ($state) => $state === 'private' ? 'info' : 'success'),

                Tables\Columns\TextColumn::make('score_percentage')
                    ->label('Score')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->color(fn ($state) => $state >= 70 ? 'success' : 'danger'),

                Tables\Columns\IconColumn::make('is_qualified')
                    ->label('Qualified')
                    ->boolean(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray'   => 'draft',
                        'blue'   => 'submitted',
                        'yellow' => 'under_review',
                        'green'  => ['shortlisted', 'approved'],
                        'red'    => 'rejected',
                        'purple' => 'site_visit_scheduled',
                    ]),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('documents_count')
                    ->label('Docs')
                    ->counts('documents'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft'                => 'Draft',
                        'submitted'            => 'Submitted',
                        'under_review'         => 'Under Review',
                        'shortlisted'          => 'Shortlisted',
                        'rejected'             => 'Rejected',
                        'site_visit_scheduled' => 'Site Visit Scheduled',
                        'approved'             => 'Approved',
                    ]),
                SelectFilter::make('ownership_type')
                    ->relationship('hospital', 'ownership_type')
                    ->label('Ownership'),
                TernaryFilter::make('is_qualified')->label('Qualified'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('mark_under_review')
                    ->label('Mark Under Review')
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('warning')
                    ->action(fn ($record) => $record->update(['status' => 'under_review']))
                    ->visible(fn ($record) => $record->status === 'submitted'),

                Tables\Actions\Action::make('shortlist')
                    ->label('Shortlist')
                    ->icon('heroicon-o-star')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'shortlisted']))
                    ->visible(fn ($record) => $record->status === 'under_review'),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'rejected']))
                    ->visible(fn ($record) => in_array($record->status, ['submitted', 'under_review'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_under_review')
                        ->label('Mark as Under Review')
                        ->icon('heroicon-o-magnifying-glass')
                        ->action(fn ($records) => $records->each->update(['status' => 'under_review'])),
                    Tables\Actions\ExportBulkAction::make(),
                ]),
            ])
            ->defaultSort('submitted_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGrantApplications::route('/'),
            'create' => Pages\CreateGrantApplication::route('/create'),
            'edit'   => Pages\EditGrantApplication::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'submitted')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
