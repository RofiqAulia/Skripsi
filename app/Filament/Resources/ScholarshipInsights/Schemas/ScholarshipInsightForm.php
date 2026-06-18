<?php

namespace App\Filament\Resources\ScholarshipInsights\Schemas;

use App\Models\ScholarshipInsight;
use Filament\Schemas\Schema;

class ScholarshipInsightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            \Filament\Schemas\Components\Section::make('Content')
                ->components([
                    \Filament\Forms\Components\TextInput::make('title')
                        ->label('Article Title')
                        ->required()
                        ->maxLength(255),

                    \Filament\Forms\Components\TextInput::make('slug')
                        ->label('Slug (URL)')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Auto-generated from title. You can customise it.'),

                    \Filament\Forms\Components\Select::make('category')
                        ->label('Category')
                        ->options(ScholarshipInsight::CATEGORIES)
                        ->required()
                        ->default('article'),

                    \Filament\Forms\Components\TextInput::make('source_url')
                        ->label('External Source URL')
                        ->url()
                        ->placeholder('https://...')
                        ->helperText('Optional — link to the original scholarship page.'),

                    \Filament\Forms\Components\Textarea::make('excerpt')
                        ->label('Excerpt / Short Description')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull()
                        ->helperText('Shown on the home page card. Keep it concise.'),

                    \Filament\Forms\Components\RichEditor::make('body')
                        ->label('Full Article Content')
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'h2', 'h3',
                            'bulletList', 'orderedList', 'blockquote',
                            'link', 'redo', 'undo',
                        ])
                        ->columnSpanFull()
                        ->nullable(),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Publication')
                ->components([
                    \Filament\Forms\Components\FileUpload::make('cover_image')
                        ->label('Cover Image')
                        ->image()
                        ->directory('scholarship-insights')
                        ->disk('public')
                        ->imageEditor()
                        ->nullable()
                        ->columnSpanFull(),

                    \Filament\Forms\Components\Toggle::make('is_published')
                        ->label('Published')
                        ->default(false),

                    \Filament\Forms\Components\DateTimePicker::make('published_at')
                        ->label('Publish Date & Time')
                        ->nullable()
                        ->helperText('Leave blank to set automatically when published.'),
                ])->columns(2),

        ]);
    }
}
