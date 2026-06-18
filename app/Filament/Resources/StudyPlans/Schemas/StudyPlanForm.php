<?php

namespace App\Filament\Resources\StudyPlans\Schemas;

use Filament\Schemas\Schema;

class StudyPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('program_study_id')
                    ->relationship('program', 'name')
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('scholarship_id')
                    ->relationship('scholarship', 'title')
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Textarea::make('future_competence')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
