<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Document;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(),

                \Filament\Forms\Components\Select::make('type')
                    ->options(Document::REQUIRED_TYPES + ['other' => 'Other / Supporting'])
                    ->required()
                    ->disabled(),

                \Filament\Forms\Components\Select::make('category')
                    ->options([
                        'required' => 'Required',
                        'other'    => 'Other / Supporting',
                    ])
                    ->required()
                    ->disabled(),

                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'uploaded' => 'Uploaded (Awaiting Review)',
                        'approved' => 'Approved',
                        'revisi' => 'Revisi',
                    ])
                    ->required(),

                \Filament\Forms\Components\Textarea::make('notes')
                    ->label('Admin Notes')
                    ->placeholder('Enter notes for the user...')
                    ->columnSpanFull(),

                \Filament\Forms\Components\Select::make('reviewed_by')
                    ->relationship('reviewer', 'name')
                    ->searchable()
                    ->preload(),

                \Filament\Forms\Components\DateTimePicker::make('reviewed_at')
                    ->label('Reviewed At'),
            ]);
    }
}
