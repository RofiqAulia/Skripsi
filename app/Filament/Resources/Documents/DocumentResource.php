<?php

namespace App\Filament\Resources\Documents;

use App\Filament\Resources\Documents\Pages\EditDocument;
use App\Filament\Resources\Documents\Pages\ListDocuments;
use App\Filament\Resources\Documents\Schemas\DocumentForm;
use App\Filament\Resources\Documents\Tables\DocumentsTable;
use App\Models\Document;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static string | UnitEnum | null $navigationGroup = 'Master Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowUp;
    protected static ?int $navigationSort = 1;
    public static function canViewAny(): bool
    {
        return true;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->check() && auth()->user()->hasRole('mentor')) {
            $mentor = auth()->user()->mentor;
            if ($mentor) {
                $studentIds = $mentor->sessions()->pluck('user_id');
                $query->whereIn('user_id', $studentIds);
            } else {
                $query->where('id', 0);
            }
        }
        return $query;
    }


    public static function form(Schema $schema): Schema
    {
        return DocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocumentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocuments::route('/'),
            'edit' => EditDocument::route('/{record}/edit'),
        ];
    }
}
