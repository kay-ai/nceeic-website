<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationDocumentResource\Pages;
use App\Filament\Resources\ApplicationDocumentResource\RelationManagers;
use App\Models\ApplicationDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationDocumentResource extends Resource
{
    protected static ?string $model = ApplicationDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationGroup = 'Grant Management';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('document_type')->disabled(),
                Forms\Components\TextInput::make('original_filename')->disabled(),
                Forms\Components\TextInput::make('verification_status')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application.hospital.hospital_name')
                    ->label('Hospital')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_type')
                    ->label('Document Type')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'financial_statements' => 'Financial Statements',
                        'energy_consumption_report' => 'Energy Consumption',
                        'fuel_expenditure_report' => 'Fuel Expenditure',
                        'iso_certification' => 'ISO Certification',
                        'management_certifications' => 'Management Certifications',
                        'cofinancing_proof' => 'Co-financing Proof',
                        default => ucwords(str_replace('_', ' ', $state)),
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('original_filename')
                    ->label('Filename')
                    ->searchable()
                    ->wrap()
                    ->limit(50),
                Tables\Columns\TextColumn::make('file_size')
                    ->formatStateUsing(fn ($state) => match(true) {
                        $state >= 1048576 => round($state / 1048576, 2) . ' MB',
                        $state >= 1024 => round($state / 1024, 2) . ' KB',
                        default => $state . ' bytes',
                    }),
                Tables\Columns\BadgeColumn::make('verification_status')
                    ->colors([
                        'gray' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('hospital')
                    ->relationship('application.hospital', 'hospital_name')
                    ->label('Hospital')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('document_type')
                    ->options([
                        'financial_statements' => 'Financial Statements',
                        'energy_consumption_report' => 'Energy Consumption',
                        'fuel_expenditure_report' => 'Fuel Expenditure',
                        'iso_certification' => 'ISO Certification',
                        'management_certifications' => 'Management Certifications',
                        'cofinancing_proof' => 'Co-financing Proof',
                    ])
                    ->label('Document Type'),
                SelectFilter::make('verification_status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('documents.download', ['document' => $record, 'type' => 'view']))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => route('documents.download', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplicationDocuments::route('/'),
            'edit' => Pages\EditApplicationDocument::route('/{record}/edit'),
        ];
    }
}
