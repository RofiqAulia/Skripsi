<?php

namespace App\Filament\Resources\ProgramStudies\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;

class ProgramStudyForm
{
    public static function configure(Schema $schema): Schema
    {


        return $schema
            ->components([

                Section::make('General Information')
                    ->components([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'revision' => 'Revision',
                                'rejected' => 'Rejected',
                            ])
                            ->default('approved')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('admin_notes')
                            ->label('Admin Notes (for Revision/Rejection)')
                            ->columnSpanFull(),
                        Select::make('competency')
                            ->label('Competency')
                            ->options(function (?Illuminate\Database\Eloquent\Model $record) {
                                $options = \App\Models\Competency::active()->pluck('name', 'name')->toArray();
                                if ($record && $record->competency && !array_key_exists($record->competency, $options)) {
                                    $options[$record->competency] = $record->competency;
                                }
                                return $options;
                            })
                            ->searchable()
                            ->required(),
                        TextInput::make('name')
                            ->label('Program Study')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('scholarship')
                            ->label('Scholarship Name')
                            ->maxLength(255),
                        TextInput::make('degree')
                            ->label('Degree')
                            ->maxLength(255),
                        TextInput::make('university')
                            ->label('University')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('qs_rank')
                            ->label('QS World Rank 2025')
                            ->numeric(),
                        Select::make('country')
                            ->label('Country')
                            ->options(\App\Models\Country::pluck('name', 'name')->toArray())
                            ->searchable()
                            ->required(),
                        TextInput::make('website')
                            ->label('Website Link')
                            ->url()
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Study Details')
                    ->components([
                        Select::make('study_type')
                            ->label('Study Type')
                            ->options([
                                'Full-time'       => 'Full-time',
                                'Part-time'       => 'Part-time',
                                'Online'          => 'Online',
                                'Blended'         => 'Blended',
                            ]),
                        TextInput::make('study_duration')
                            ->label('Study Duration (years)')
                            ->maxLength(50),
                        TextInput::make('gpa')
                            ->label('GPA Requirement')
                            ->maxLength(50),
                        TextInput::make('intake')
                            ->label('Intake')
                            ->maxLength(100),
                    ])->columns(2),

                Section::make('Language & Test Requirements')
                    ->components([
                        Repeater::make('english_test')
                            ->label('English Test')
                            ->schema([
                                TextInput::make('test_name')->label('Test Name'),
                                TextInput::make('minimum_score')->label('Minimum Score'),
                            ])
                            ->maxItems(5)
                            ->columnSpanFull(),
                        TextInput::make('other_language')
                            ->label('Other Language Test')
                            ->maxLength(255),
                        TextInput::make('standardized_test')
                            ->label('Standardized Test')
                            ->maxLength(255),
                        Toggle::make('req_standardized_test')
                            ->label('Standardized Test Required?'),
                        Textarea::make('other')
                            ->label('Others')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Document Requirements & Process')
                    ->components([
                        Textarea::make('requirements')
                            ->label('Requirements')
                            ->columnSpanFull(),
                        Textarea::make('registration_process')
                            ->label('Registration Process & Selection')
                            ->columnSpanFull(),
                    ]),

                Section::make('Registration Timeline')
                    ->components([
                        DatePicker::make('open_date')
                            ->label('Opening Date'),
                        DatePicker::make('deadline')
                            ->label('Closing Date'),
                        DatePicker::make('screening_date')
                            ->label('Application Screening Date'),
                        DatePicker::make('written_test_date')
                            ->label('Written Test Date'),
                        DatePicker::make('interview_date')
                            ->label('Interview Date'),
                        DatePicker::make('shortlist_date')
                            ->label('Shortlist Announcement Date'),
                    ])->columns(2),

            ]);
    }
}
