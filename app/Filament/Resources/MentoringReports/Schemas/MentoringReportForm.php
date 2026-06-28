<?php

namespace App\Filament\Resources\MentoringReports\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use App\Models\MentoringSession;

class MentoringReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ✅ Pilih Session (bukan ID)
                Select::make('mentoring_session_id')
                    ->label('Session')
                    ->options(
                        MentoringSession::with(['user', 'mentor.user', 'schedule'])
                            ->get()
                            ->mapWithKeys(function ($session) {
                                return [
                                    $session->id =>
                                        $session->user->name . ' | ' .
                                        $session->mentor->user->name . ' | ' .
                                        $session->schedule->date . ' (' .
                                        $session->schedule->start_time . '-' .
                                        $session->schedule->end_time . ')'
                                ];
                            })
                    )
                    ->searchable()
                    ->required(),

                // ✅ Pertemuan ke berapa
                TextInput::make('meeting_number')
                    ->label('Meeting Number')
                    ->numeric()
                    ->required(),

                // ✅ Summary
                Textarea::make('summary')
                    ->required()
                    ->columnSpanFull(),

                // ✅ Output
                Textarea::make('output')
                    ->columnSpanFull(),

                // ✅ File Upload
                FileUpload::make('file')
                    ->disk('public')
                    ->directory('mentoring-reports')
                    ->downloadable()
                    ->openable(),

                // ✅ Catatan mentor
                Textarea::make('mentor_notes')
                    ->label('Mentor Notes')
                    ->columnSpanFull(),

                // ✅ Status
                Select::make('status')
                    ->options([
                        'draft'     => 'Draft',
                        'submitted' => 'Submitted',
                        'revision'  => 'Revision',
                        'rejected'  => 'Rejected',
                        'approved'  => 'Approved',
                    ])
                    ->required(),
            ]);
    }
}