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
                    ->default(fn () => auth()->id())
                    ->disabled(fn () => !auth()->user()->hasRole('super_admin'))
                    ->dehydrated()
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
                \Filament\Schemas\Components\Section::make('Approval State')
                    ->schema([
                        \Filament\Forms\Components\Select::make('approval_stage')
                            ->options([
                                0 => '0 - Submission (Waiting Dept)',
                                1 => '1 - Department Approved (Waiting Group)',
                                2 => '2 - Group Approved (Waiting Direktorat)',
                                3 => '3 - Direktorat Approved (Final)',
                            ])
                            ->disableOptionWhen(function (string $value, ?\Illuminate\Database\Eloquent\Model $record): bool {
                                $user = auth()->user();
                                if ($user->hasRole('super_admin')) {
                                    return false; // all options enabled
                                }
                                
                                $val = (int) $value;
                                
                                // 1. Selalu perbolehkan opsi yang saat ini tersimpan di database agar form bisa disimpan (tanpa mengubah stage)
                                if ($record && $val === (int) $record->approval_stage) {
                                    return false;
                                }

                                // 2. Jika opsi yang dievaluasi adalah 1 (Dept Approved), pastikan user adalah Dept Head
                                if ($val === 1) {
                                    return !\App\Models\Department::where('head_id', $user->id)->exists();
                                }

                                // 3. Jika opsi yang dievaluasi adalah 2 (Group Approved), pastikan user adalah Group Head
                                if ($val === 2) {
                                    return !\App\Models\Group::where('head_id', $user->id)->exists();
                                }

                                // 4. Jika opsi yang dievaluasi adalah 3 (Dir Approved), pastikan user adalah Dir Head
                                if ($val === 3) {
                                    return !\App\Models\Direktorat::where('head_id', $user->id)->exists();
                                }
                                
                                // Opsi 0 (Submission) hanya bisa dipilih/dikembalikan oleh Dept Head
                                if ($val === 0) {
                                    return !\App\Models\Department::where('head_id', $user->id)->exists();
                                }
                                
                                return true; // Sisanya disable
                            })
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $old, callable $set) {
                                $user = auth()->user();
                                
                                // Jika maju (Approval)
                                if ($state > $old) {
                                    if ($state == 1) $set('department_approver_id', $user->id);
                                    if ($state == 2) $set('group_approver_id', $user->id);
                                    if ($state == 3) $set('direktorat_approver_id', $user->id);
                                }
                                
                                // Jika mundur (Revisi/Pembatalan)
                                if ($state < 1) $set('department_approver_id', null);
                                if ($state < 2) $set('group_approver_id', null);
                                if ($state < 3) $set('direktorat_approver_id', null);
                            }),
                        \Filament\Forms\Components\Select::make('status')
                            ->options([
                                'submission' => 'Submission',
                                'review' => 'Revision',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->reactive(),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Approvers (Auto-filled by system)')
                    ->schema([
                        \Filament\Forms\Components\Select::make('department_approver_id')
                            ->relationship('departmentApprover', 'name')
                            ->label('Department Approver')
                            ->disabled()
                            ->dehydrated()
                            ->afterStateHydrated(function (\Filament\Forms\Components\Select $component, $state) {
                                $user = auth()->user();
                                if (!$state && \App\Models\Department::where('head_id', $user->id)->exists()) {
                                    $component->state($user->id);
                                }
                            }),
                        \Filament\Forms\Components\Select::make('group_approver_id')
                            ->relationship('groupApprover', 'name')
                            ->label('Group Approver')
                            ->disabled()
                            ->dehydrated()
                            ->afterStateHydrated(function (\Filament\Forms\Components\Select $component, $state) {
                                $user = auth()->user();
                                if (!$state && \App\Models\Group::where('head_id', $user->id)->exists()) {
                                    $component->state($user->id);
                                }
                            }),
                        \Filament\Forms\Components\Select::make('direktorat_approver_id')
                            ->relationship('direktoratApprover', 'name')
                            ->label('Direktorat Approver')
                            ->disabled()
                            ->dehydrated()
                            ->afterStateHydrated(function (\Filament\Forms\Components\Select $component, $state) {
                                $user = auth()->user();
                                if (!$state && \App\Models\Direktorat::where('head_id', $user->id)->exists()) {
                                    $component->state($user->id);
                                }
                            }),
                    ])->columns(3),

                \Filament\Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),

                // ===== SIGNATURE SECTION =====
                \Filament\Schemas\Components\Section::make('Approval Signature')
                    ->description('Choose one method: upload a signature image OR draw directly using mouse/pen. (For final approval)')
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
