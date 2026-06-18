<?php

namespace App\Filament\Resources\MentoringSessions;

use App\Filament\Resources\MentoringSessions\Pages\CreateMentoringSession;
use App\Filament\Resources\MentoringSessions\Pages\EditMentoringSession;
use App\Filament\Resources\MentoringSessions\Pages\ListMentoringSessions;
use App\Filament\Resources\MentoringSessions\Schemas\MentoringSessionForm;
use App\Filament\Resources\MentoringSessions\Tables\MentoringSessionsTable;
use App\Models\MentoringSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MentoringSessionResource extends Resource
{
    protected static ?string $model = MentoringSession::class;

    protected static ?int $navigationSort = 3;
    protected static string | UnitEnum | null $navigationGroup = 'Mentoring System';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return MentoringSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MentoringSessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMentoringSessions::route('/'),
            'create' => CreateMentoringSession::route('/create'),
            'edit' => EditMentoringSession::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('mentor')) {
            $query->where('mentor_id', auth()->user()->mentor->id);
        }

        return $query;
    }
}
