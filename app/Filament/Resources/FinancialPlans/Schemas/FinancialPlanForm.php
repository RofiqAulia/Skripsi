<?php
 
namespace App\Filament\Resources\FinancialPlans\Schemas;
 
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
 
class FinancialPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([  
                Section::make('Study Details')
                    ->components([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Mentee')
                            ->default(fn () => auth()->id())
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('scholarship_application_id')
                            ->relationship('scholarshipApplication', 'id')
                            ->label('Scholarship Application')
                            ->getOptionLabelFromRecordUsing(fn ($record) => ($record->programStudy?->scholarship ?? 'Scholarship') . ' — ' . ($record->programStudy?->name ?? 'Program Study'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                if (!$state) {
                                    $set('scholarship_name', '-');
                                    $set('program_study_name', '-');
                                    $set('university_name', '');
                                    $set('country_destination', '');
                                    $set('study_duration_month', '');
                                    return;
                                }
                                $app = \App\Models\ScholarshipApplication::with('programStudy')->find($state);
                                if ($app && $app->programStudy) {
                                    $set('scholarship_name', $app->programStudy->scholarship ?? '-');
                                    $set('program_study_name', $app->programStudy->name ?? '-');
                                    $set('university_name', $app->programStudy->university ?? '');
                                    $set('country_destination', $app->programStudy->country ?? '');
                                    
                                    $durStr = $app->programStudy->study_duration;
                                    $durMonths = 12;
                                    if ($durStr) {
                                        $val = intval($durStr);
                                        if ($val > 0) {
                                            if (str_contains(strtolower($durStr), 'month')) {
                                                $durMonths = $val;
                                            } else {
                                                $durMonths = $val <= 6 ? $val * 12 : $val;
                                            }
                                        }
                                    }
                                    $set('study_duration_month', $durMonths);
                                }
                            }),
                        TextInput::make('scholarship_name')
                            ->label('Scholarship')
                            ->afterStateHydrated(function ($state, $record, $set) {
                                $set('scholarship_name', $record?->scholarshipApplication?->programStudy?->scholarship ?? '-');
                            })
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('program_study_name')
                            ->label('Program Study')
                            ->afterStateHydrated(function ($state, $record, $set) {
                                $set('program_study_name', $record?->scholarshipApplication?->programStudy?->name ?? '-');
                            })
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('university_name')
                            ->label('University')
                            ->disabled(),
                        TextInput::make('country_destination')
                            ->label('Country')
                            ->disabled(),
                        TextInput::make('study_duration_month')
                            ->label('Study Duration (Months)')
                            ->disabled(),
                        TextInput::make('currency')
                            ->label('Currency')
                            ->disabled(),
                    ])->columns(2),
 
                Section::make('Funding & Cost Summary')
                    ->components([
                        TextInput::make('total_estimated_cost')->disabled()->numeric(),
                        TextInput::make('total_funding')->disabled()->numeric(),
                        TextInput::make('funding_gap')->disabled()->numeric(),
                        TextInput::make('readiness_percentage')->disabled()->numeric()->suffix('%'),
                        Select::make('risk_level')->disabled()->options(['low' => 'Low Risk', 'medium' => 'Moderate Risk', 'high' => 'High Risk']),
                    ])->columns(3),
 
                Section::make('Financial Categories (Costs & Coverages)')
                    ->components([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                TextInput::make('category')->disabled(),
                                TextInput::make('item_name')->disabled(),
                                TextInput::make('estimated_cost')->numeric()->disabled(),
                                TextInput::make('scholarship_coverage')->numeric()->disabled(),
                                TextInput::make('gap_amount')->numeric()->disabled(),
                                \Filament\Forms\Components\Placeholder::make('reference_file_path')
                                    ->label('Reference File')
                                    ->content(fn ($record) => $record && $record->reference_file_path 
                                        ? new \Illuminate\Support\HtmlString('<a href="'.\Illuminate\Support\Facades\Storage::url($record->reference_file_path).'" target="_blank" style="color:blue; text-decoration:underline;">View/Download</a>') 
                                        : 'No File'),
                            ])
                            ->columns(3)
                            ->disableItemCreation()
                            ->disableItemDeletion()
                            ->disableItemMovement(),
                    ])->collapsible(),
 
                Section::make('Supporting Documents')
                    ->components([
                        Repeater::make('documents')
                            ->relationship('documents')
                            ->schema([
                                TextInput::make('document_type')->disabled(),
                                TextInput::make('original_name')->disabled(),
                                FileUpload::make('file_path')
                                    ->label('File')
                                    ->disk('public')
                                    ->openable()
                                    ->downloadable()
                                    ->disabled(),
                                Select::make('verification_status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'verified' => 'Verified',
                                        'rejected' => 'Rejected',
                                    ]),
                             ])
                            ->columns(2)
                            ->disableItemCreation()
                            ->disableItemDeletion()
                            ->disableItemMovement(),
                    ])->collapsible(),
 
                Section::make('Admin Review')
                    ->components([
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Submitted',
                                'under_review' => 'Under review',
                                'revision_needed' => 'Revision needed',
                                'approved' => 'Approved',
                            ])
                            ->required(),
                        Textarea::make('admin_notes')
                            ->label('Admin Notes & Feedback')
                            ->columnSpanFull()
                            ->rows(4),
                    ])->columns(1),
            ]);
    }
}
