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
        $competencyOptions = [
            'Advance Mining Engineering'                       => 'Advance Mining Engineering',
            'Advance Process Engineering'                      => 'Advance Process Engineering',
            'Advance Digital analytics & Data Science'         => 'Advance Digital analytics & Data Science',
            'Artificial Intelligence'                          => 'Artificial Intelligence',
            'Robotic Process Automation'                       => 'Robotic Process Automation',
            'Strategic Transformation & Project Management'    => 'Strategic Transformation & Project Management',
            'Strategic Portfolio & Investment Management'      => 'Strategic Portfolio & Investment Management',
            'Strategic & Management Business & Administration' => 'Strategic & Management Business & Administration',
            'Business Analysis'                                => 'Business Analysis',
            'Business Development'                             => 'Business Development',
            'Marketing & Sales Strategy'                       => 'Marketing & Sales Strategy',
            'Digital Marketing'                                => 'Digital Marketing',
            'Sociology & Psychology'                           => 'Sociology & Psychology',
            'Strategic Human Capital & Psychometric'           => 'Strategic Human Capital & Psychometric',
            'Waste Management'                                 => 'Waste Management',
            'Renewable Energy & CO2'                           => 'Renewable Energy & CO2',
            'Corporate Sustainability & ESG'                   => 'Corporate Sustainability & ESG',
            'Health Safety Environment'                        => 'Health Safety Environment',
        ];

        return $schema
            ->components([

                Section::make('General Information')
                    ->components([
                        Select::make('competency')
                            ->label('Competency')
                            ->options($competencyOptions)
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
                        TextInput::make('country')
                            ->label('Country')
                            ->required()
                            ->maxLength(255),
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
                                TextInput::make('test_name')->label('Test Name')->required(),
                                TextInput::make('minimum_score')->label('Minimum Score')->required(),
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
