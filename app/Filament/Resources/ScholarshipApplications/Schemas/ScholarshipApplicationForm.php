<?php

namespace App\Filament\Resources\ScholarshipApplications\Schemas;

use App\Models\ScholarshipApplication;
use Filament\Schemas\Schema;

class ScholarshipApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            \Filament\Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->required()
                ->searchable()
                ->preload()
                ->label('Mentee'),

            \Filament\Forms\Components\TextInput::make('program_study_scholarship')
                ->label('Beasiswa')
                ->disabled()
                ->formatStateUsing(fn ($record) => $record?->programStudy?->scholarship),

            \Filament\Forms\Components\TextInput::make('program_study_country')
                ->label('Negara')
                ->disabled()
                ->formatStateUsing(fn ($record) => $record?->programStudy?->country),

            \Filament\Forms\Components\Select::make('program_study_id')
                ->relationship('programStudy', 'name')
                ->required()
                ->searchable()
                ->preload()
                ->label('Program Studi'),

            \Filament\Forms\Components\Select::make('psp_application_id')
                ->relationship('pspApplication', 'id')
                ->searchable()
                ->preload()
                ->nullable()
                ->label('PSP Application (opsional)'),

            \Filament\Forms\Components\TextInput::make('university')
                ->label('Universitas')
                ->nullable()
                ->maxLength(255),

            \Filament\Forms\Components\Select::make('current_stage')
                ->options(ScholarshipApplication::STAGES)
                ->required()
                ->label('Tahapan Saat Ini'),

            \Filament\Forms\Components\Select::make('status')
                ->options(ScholarshipApplication::STATUSES)
                ->required()
                ->label('Status'),

            \Filament\Forms\Components\DatePicker::make('updated_date')
                ->required()
                ->label('Tanggal Update'),

            \Filament\Forms\Components\Textarea::make('notes')
                ->nullable()
                ->columnSpanFull()
                ->label('Catatan'),

        ]);
    }
}
