<?php
 
namespace App\Filament\Resources\FinancialPlans\Schemas;
 
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
 
class FinancialPlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Study Details')
                    ->components([
                        TextEntry::make('user.name')->label('Mentee'),
                        TextEntry::make('scholarship_name')
                            ->label('Scholarship')
                            ->getStateUsing(fn ($record) => $record?->scholarshipApplication?->programStudy?->scholarship ?? '-'),
                        TextEntry::make('program_study_name')
                            ->label('Program Study')
                            ->getStateUsing(fn ($record) => $record?->scholarshipApplication?->programStudy?->name ?? '-'),
                        TextEntry::make('university_name')->label('University'),
                        TextEntry::make('country_destination')->label('Country'),
                        TextEntry::make('study_duration_month')->label('Duration (Months)'),
                        TextEntry::make('currency')->label('Currency'),
                    ])->columns(2),
 
                Section::make('Funding & Cost Summary')
                    ->components([
                        TextEntry::make('total_estimated_cost')->money('IDR'),
                        TextEntry::make('total_funding')->money('IDR'),
                        TextEntry::make('funding_gap')->money('IDR'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'submitted' => 'info',
                                'under_review' => 'warning',
                                'revision_needed' => 'danger',
                                'approved' => 'success',
                                default => 'gray',
                            }),
                    ])->columns(3),
 
                Section::make('Budget Items Breakdown')
                    ->description('Detail of estimated costs, scholarship coverage, and reference files per item.')
                    ->components([
                        \Filament\Infolists\Components\RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                TextEntry::make('category')
                                    ->label('Category')
                                    ->badge()
                                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                                TextEntry::make('item_name')->label('Item'),
                                TextEntry::make('estimated_cost')
                                    ->label('Estimated Cost')
                                    ->numeric(decimalPlaces: 2),
                                TextEntry::make('scholarship_coverage')
                                    ->label('Scholarship Coverage')
                                    ->numeric(decimalPlaces: 2),
                                TextEntry::make('gap_amount')
                                    ->label('Gap')
                                    ->numeric(decimalPlaces: 2)
                                    ->color(fn ($state) => $state >= 0 ? 'success' : 'danger'),
                                TextEntry::make('reference_file_path')
                                    ->label('Reference File')
                                    ->getStateUsing(fn ($record) => $record->reference_file_name ? '📄 ' . $record->reference_file_name : null)
                                    ->placeholder('No file')
                                    ->url(fn ($record) => $record->reference_file_path
                                        ? \Illuminate\Support\Facades\Storage::url($record->reference_file_path)
                                        : null)
                                    ->openUrlInNewTab()
                                    ->color('primary'),
                            ])->columns(6)
                    ])->collapsible(),
 
                Section::make('Supporting Documents')
                    ->components([
                        \Filament\Infolists\Components\RepeatableEntry::make('documents')
                            ->schema([
                                TextEntry::make('document_type')->label('Type'),
                                TextEntry::make('original_name')->label('File Name'),
                                TextEntry::make('verification_status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'verified' => 'success',
                                        'rejected' => 'danger',
                                        default => 'warning',
                                    }),
                                TextEntry::make('file_path')
                                    ->label('Download')
                                    ->formatStateUsing(fn () => '📄 View / Download')
                                    ->url(fn ($record) => \Illuminate\Support\Facades\Storage::url($record->file_path))
                                    ->openUrlInNewTab()
                                    ->color('primary'),
                            ])->columns(4)
                    ])->collapsible(),
 
                Section::make('Feedback & Timeline')
                    ->components([
                        TextEntry::make('admin_notes')
                            ->label('Admin Notes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('submitted_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('approved_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])->columns(2),
            ]);
    }
}
