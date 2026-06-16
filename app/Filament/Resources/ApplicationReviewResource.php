<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationReviewResource\Pages;
use App\Models\ApplicationReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class ApplicationReviewResource extends Resource
{
    protected static ?string $model = ApplicationReview::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationGroup = 'Grant Management';
    protected static ?int $navigationSort = 5;
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Review Information')
                ->schema([
                    Forms\Components\TextInput::make('application.application_id')
                        ->disabled()
                        ->label('Application ID'),
                    Forms\Components\TextInput::make('application.hospital.hospital_name')
                        ->disabled()
                        ->label('Hospital'),
                    Forms\Components\TextInput::make('reviewer.name')
                        ->disabled()
                        ->label('Reviewer'),
                    Forms\Components\DateTimePicker::make('reviewed_at')
                        ->disabled()
                        ->label('Reviewed On'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Scoring')
                ->schema([
                    Forms\Components\TextInput::make('score_ownership')
                        ->numeric()->minValue(0)->maxValue(15)
                        ->label('Ownership Score (max 15)'),
                    Forms\Components\TextInput::make('score_beds')
                        ->numeric()->minValue(0)->maxValue(10)
                        ->label('Beds Score (max 10)'),
                    Forms\Components\TextInput::make('score_icu_or')
                        ->numeric()->minValue(0)->maxValue(15)
                        ->label('ICU/OR Score (max 15)'),
                    Forms\Components\TextInput::make('score_revenue_mix')
                        ->numeric()->minValue(0)->maxValue(10)
                        ->label('Revenue Mix (max 10)'),
                    Forms\Components\TextInput::make('score_energy_use')
                        ->numeric()->minValue(0)->maxValue(15)
                        ->label('Energy Use (max 15)'),
                    Forms\Components\TextInput::make('score_iso')
                        ->numeric()->minValue(0)->maxValue(15)
                        ->label('ISO Compliance (max 15)'),
                    Forms\Components\TextInput::make('score_cofinancing')
                        ->numeric()->minValue(0)->maxValue(10)
                        ->label('Co-financing (max 10)'),
                    Forms\Components\TextInput::make('score_maintenance')
                        ->numeric()->minValue(0)->maxValue(10)
                        ->label('Maintenance (max 10)'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Recommendation')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'recommended' => 'Recommended for Approval',
                            'conditional' => 'Conditional Recommendation',
                            'not_recommended' => 'Not Recommended',
                        ])
                        ->required(),
                    Forms\Components\Toggle::make('site_visit_required')
                        ->label('Site Visit Required?'),
                    Forms\Components\Textarea::make('comments')
                        ->rows(5)
                        ->columnSpanFull()
                        ->helperText('Detailed feedback on the application'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application.application_id')
                    ->searchable()
                    ->sortable()
                    ->label('Application ID'),
                Tables\Columns\TextColumn::make('application.hospital.hospital_name')
                    ->searchable()
                    ->sortable()
                    ->label('Hospital'),
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('Reviewer'),
                Tables\Columns\TextColumn::make('total_score')
                    ->label('Score')
                    ->formatStateUsing(fn ($state) => $state . '/100')
                    ->color(fn ($record) => $record->isQualified() ? 'success' : 'danger'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'recommended',
                        'warning' => 'conditional',
                        'danger' => 'not_recommended',
                    ]),
                Tables\Columns\IconColumn::make('site_visit_required')
                    ->boolean()
                    ->label('Site Visit'),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'recommended' => 'Recommended',
                        'conditional' => 'Conditional',
                        'not_recommended' => 'Not Recommended',
                    ]),
            ])
            ->defaultSort('reviewed_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListApplicationReviews::route('/'),
            'create' => Pages\CreateApplicationReview::route('/create'),
            'edit'   => Pages\EditApplicationReview::route('/{record}/edit'),
        ];
    }
}
