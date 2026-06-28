<?php

namespace App\Filament\Resources\PspApplications\Schemas;

use Filament\Schemas\Schema;
use App\Filament\Forms\Components\SignaturePad;

class PspApplicationForm
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
                \Filament\Forms\Components\Select::make('study_plan_id')
                    ->relationship('studyPlan', 'id')
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Textarea::make('study_plan_text')
                    ->label('Research Topic')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\Placeholder::make('attached_files')
                    ->label('Uploaded Documents')
                    ->content(function ($record) {
                        if (!$record || !$record->studyPlan || empty($record->studyPlan->files)) {
                            return 'No files attached.';
                        }
                        
                        $html = '<ul style="list-style-type: none; padding: 0; margin: 0;">';
                        foreach ($record->studyPlan->files as $file) {
                            $url = \Illuminate\Support\Facades\Storage::disk('public')->url($file['path']);
                            $name = $file['original_name'] ?? 'Download File';
                            $html .= '<li style="margin-bottom: 5px;"><a href="' . $url . '" target="_blank" style="color: #0284c7; text-decoration: underline; font-weight: 500;">📄 ' . e($name) . '</a></li>';
                        }
                        $html .= '</ul>';
                        
                        return new \Illuminate\Support\HtmlString($html);
                    })
                    ->columnSpanFull(),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'submission' => 'Submission',
                        'review' => 'Revision',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->reactive(),
                \Filament\Forms\Components\Select::make('approved_by')
                    ->relationship('approver', 'name')
                    ->searchable()
                    ->preload()
                    ->afterStateHydrated(function (\Filament\Forms\Components\Select $component, $state) {
                        if (empty($state)) {
                            $component->state(auth()->id());
                        }
                    }),
                \Filament\Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),

                // ===== SIGNATURE SECTION =====
                \Filament\Schemas\Components\Section::make('Approval Signature')
                    ->description('Choose one method: upload a signature image OR draw directly using mouse/pen.')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('signature_image')
                            ->label('Upload Signature Image')
                            ->image()
                            ->disk('public')
                            ->directory('signatures')
                            ->helperText('Upload a digital signature image file (PNG/JPG).')
                            ->columnSpanFull(),

                        SignaturePad::make('signature_pad')
                            ->label('Or Draw Signature Directly')
                            ->width(500)
                            ->height(200)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(fn ($get) => !in_array($get('status'), ['approved']))
                    ->visible(fn ($get) => in_array($get('status'), ['approved', 'rejected']) || true)
                    ->columnSpanFull(),
            ]);
    }
}
