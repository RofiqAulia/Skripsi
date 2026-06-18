<?php

namespace App\Filament\Resources\ScholarshipInsights\Tables;

use App\Models\ScholarshipInsight;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ScholarshipInsightsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->disk('public')
                    ->height(48)
                    ->width(72)
                    ->defaultImageUrl(asset('images/scholarships-.jpeg'))
                    ->extraImgAttributes(['style' => 'object-fit:cover;border-radius:6px']),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(60)
                    ->weight('semibold'),

                TextColumn::make('category')
                    ->label('Category')
                    ->formatStateUsing(fn ($state) => ScholarshipInsight::CATEGORIES[$state] ?? ucfirst($state))
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'opportunity' => 'success',
                        'guide'       => 'info',
                        'tip'         => 'warning',
                        default       => 'gray',
                    }),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('published_at')
                    ->label('Published At')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('author.name')
                    ->label('Author')
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options(ScholarshipInsight::CATEGORIES),

                TernaryFilter::make('is_published')
                    ->label('Published')
                    ->trueLabel('Published only')
                    ->falseLabel('Draft only')
                    ->native(false),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
