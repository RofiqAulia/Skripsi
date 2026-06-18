<?php

namespace App\Filament\Resources\Scholarships\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;

class ScholarshipForm
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
                        TextInput::make('title')
                            ->label('Scholarship Name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Select::make('funding_type')
                            ->label('Scholarship Type')
                            ->options([
                                'Full'    => 'Full Scholarship',
                                'Partial' => 'Partial Scholarship',
                            ]),
                        TextInput::make('intake')
                            ->label('Intake')
                            ->maxLength(100),
                        TextInput::make('website')
                            ->label('Website Link')
                            ->url()
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Textarea::make('commitment')
                            ->label('Commitment')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Study Program')
                    ->components([
                        Select::make('competency')
                            ->label('Competency')
                            ->options($competencyOptions)
                            ->searchable(),
                        Select::make('program_study_id')
                            ->label('Study Program')
                            ->relationship('programStudy', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('country')
                            ->label('Country/University')
                            ->maxLength(255),
                        TextInput::make('study_count')
                            ->label('Number of Study Program Options')
                            ->numeric(),
                        TextInput::make('study_duration')
                            ->label('Study Duration')
                            ->maxLength(50),
                    ])->columns(2),

                Section::make('Requirements')
                    ->components([
                        TextInput::make('age')
                            ->label('Age Limit')
                            ->numeric(),
                        TextInput::make('gpa')
                            ->label('GPA Requirement')
                            ->maxLength(50),
                        TextInput::make('nationality')
                            ->label('Nationality Eligibility')
                            ->maxLength(255),
                        Textarea::make('eligibility')
                            ->label('Eligibility')
                            ->columnSpanFull(),

                        Repeater::make('english_test')
                            ->label('English Language Test')
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

                Section::make('Documents & Process')
                    ->components([
                        Repeater::make('document')
                            ->label('Document Requirements')
                            ->schema([
                                TextInput::make('document_name')->label('Document Name')->required(),
                            ])
                            ->maxItems(20)
                            ->columnSpanFull(),
                        Textarea::make('registration_process')
                            ->label('Registration Method & Selection Process')
                            ->columnSpanFull(),
                    ]),

                Section::make('Benefits')
                    ->components([
                        Repeater::make('benefit')
                            ->label('Scholarship Benefits')
                            ->schema([
                                TextInput::make('benefit_detail')->label('Benefit Detail')->required(),
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Registration Timeline')
                    ->components([
                        DatePicker::make('open_date')
                            ->label('Opening Date'),
                        DatePicker::make('deadline')
                            ->label('Closing Date'),
                        DatePicker::make('screening_date')
                            ->label('Application Screening'),
                        DatePicker::make('written_test_date')
                            ->label('Written Test'),
                        DatePicker::make('interview_date')
                            ->label('Interview'),
                        DatePicker::make('shortlist_date')
                            ->label('Shortlist Announcement'),
                    ])->columns(2),

            ]);
    }
}
