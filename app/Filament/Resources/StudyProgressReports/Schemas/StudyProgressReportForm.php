<?php

namespace App\Filament\Resources\StudyProgressReports\Schemas;

use Filament\Schemas\Schema;

class StudyProgressReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Tabs::make('Laporan Perkembangan Studi')
                ->tabs([
                    \Filament\Schemas\Components\Tabs\Tab::make('Data Karyawan & Studi')
                        ->schema([
                            \Filament\Forms\Components\Select::make('user_id')
                                ->relationship('user', 'name')
                                ->default(fn() => auth()->id())
                                ->disabled()
                                ->dehydrated()
                                ->required(),
                            \Filament\Forms\Components\Select::make('psp_application_id')
                                ->relationship('pspApplication', 'study_plan_text')
                                ->label('Program Tugas Belajar')
                                ->options(function () {
                                    $user = auth()->user();
                                    if ($user && $user->hasRole('super_admin')) {
                                        return \App\Models\PspApplication::all()->pluck('study_plan_text', 'id');
                                    }
                                    return \App\Models\PspApplication::where('user_id', auth()->id())->pluck('study_plan_text', 'id');
                                })
                                ->live()
                                ->required(),

                            \Filament\Schemas\Components\Fieldset::make('Data Karyawan')
                                ->schema([
                                    \Filament\Forms\Components\Placeholder::make('nama_karyawan')
                                        ->label('Nama')
                                        ->content(fn ($get) => $get('user_id') ? \App\Models\User::find($get('user_id'))?->name : '-'),
                                    \Filament\Forms\Components\Placeholder::make('nik_karyawan')
                                        ->label('NIK')
                                        ->content(fn ($get) => $get('user_id') ? \App\Models\User::find($get('user_id'))?->nik : '-'),
                                    \Filament\Forms\Components\Placeholder::make('posisi_karyawan')
                                        ->label('Posisi / Jabatan Semula')
                                        ->content(fn ($get) => $get('user_id') ? \App\Models\User::find($get('user_id'))?->position : '-'),
                                    \Filament\Forms\Components\Placeholder::make('unit_karyawan')
                                        ->label('Unit Kerja Semula')
                                        ->content(fn ($get) => $get('user_id') ? \App\Models\User::find($get('user_id'))?->department?->name : '-'),
                                    \Filament\Forms\Components\Placeholder::make('perusahaan_karyawan')
                                        ->label('Perusahaan')
                                        ->content(fn ($get) => $get('user_id') ? \App\Models\User::find($get('user_id'))?->company : '-'),
                                ])->columns(3),

                            \Filament\Schemas\Components\Fieldset::make('Data Studi')
                                ->schema([
                                    \Filament\Forms\Components\Placeholder::make('program_studi')
                                        ->label('Program Studi')
                                        ->content(fn ($get) => $get('psp_application_id') ? \App\Models\PspApplication::find($get('psp_application_id'))?->studyPlan?->programStudy?->name : '-'),
                                    \Filament\Forms\Components\Placeholder::make('universitas')
                                        ->label('Universitas')
                                        ->content(fn ($get) => $get('psp_application_id') ? \App\Models\PspApplication::find($get('psp_application_id'))?->studyPlan?->programStudy?->university : '-'),
                                    \Filament\Forms\Components\Placeholder::make('mulai_studi')
                                        ->label('Mulai Studi')
                                        ->content(fn ($get) => $get('psp_application_id') ? \App\Models\PspApplication::find($get('psp_application_id'))?->created_at?->format('d M Y') : '-'),
                                    \Filament\Forms\Components\Placeholder::make('lama_studi')
                                        ->label('Rencana Lama Studi')
                                        ->content(fn ($get) => $get('psp_application_id') ? \App\Models\PspApplication::find($get('psp_application_id'))?->studyPlan?->programStudy?->study_duration : '-'),
                                    
                                    \Filament\Forms\Components\TextInput::make('semester')
                                        ->numeric()
                                        ->required(),
                                    \Filament\Forms\Components\TextInput::make('gpa')
                                        ->label('IPK')
                                        ->numeric()
                                        ->step('0.01')
                                        ->required(),
                                    \Filament\Forms\Components\TextInput::make('max_gpa')
                                        ->label('Max IPK')
                                        ->numeric()
                                        ->step('0.01')
                                        ->required(),
                                ])->columns(3),
                        ]),
                    \Filament\Schemas\Components\Tabs\Tab::make('Mata Kuliah')
                        ->schema([
                            \Filament\Forms\Components\Repeater::make('completed_courses')
                                ->label('A. Mata Kuliah yang sudah dijalankan')
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('name')->label('Nama Mata Kuliah')->required(),
                                    \Filament\Forms\Components\TextInput::make('sks')->label('SKS')->numeric()->required(),
                                    \Filament\Forms\Components\TextInput::make('nilai')->label('Nilai')->required(),
                                    \Filament\Forms\Components\TextInput::make('semester')->label('Semester')->numeric()->required(),
                                ])->columns(4),
                            \Filament\Forms\Components\Repeater::make('ongoing_courses')
                                ->label('B. Mata Kuliah yang sedang dijalankan')
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('name')->label('Nama Mata Kuliah')->required(),
                                    \Filament\Forms\Components\TextInput::make('sks')->label('SKS')->numeric()->required(),
                                    \Filament\Forms\Components\TextInput::make('semester')->label('Semester')->numeric()->required(),
                                ])->columns(3),
                            \Filament\Forms\Components\Repeater::make('upcoming_courses')
                                ->label('C. Mata Kuliah yang belum dan akan dijalankan')
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('name')->label('Nama Mata Kuliah')->required(),
                                    \Filament\Forms\Components\TextInput::make('sks')->label('SKS')->numeric()->required(),
                                    \Filament\Forms\Components\TextInput::make('semester')->label('Semester')->numeric()->required(),
                                ])->columns(3),
                        ]),
                    \Filament\Schemas\Components\Tabs\Tab::make('Tesis / Penelitian')
                        ->schema([
                            \Filament\Schemas\Components\Fieldset::make('1) Judul')
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('thesis_title')->label('Judul Tesis/Penelitian'),
                                    \Filament\Forms\Components\Select::make('thesis_title_status')->label('Status')->options(['approved' => 'Approved', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                ]),
                            \Filament\Schemas\Components\Fieldset::make('2) Proposal Tesis')
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('thesis_proposal')->label('Proposal Tesis'),
                                    \Filament\Forms\Components\Select::make('thesis_proposal_status')->label('Status')->options(['approved' => 'Approved', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                ]),
                            \Filament\Schemas\Components\Fieldset::make('3) Ujian Proposal')
                                ->schema([
                                    \Filament\Forms\Components\Select::make('proposal_exam_status')->label('Status Ujian Proposal')->options(['finish' => 'Finish', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                    \Filament\Forms\Components\DatePicker::make('proposal_exam_date')->label('4) Tanggal Ujian'),
                                    \Filament\Forms\Components\TextInput::make('proposal_exam_score')->label('5) Nilai Ujian'),
                                ])->columns(3),
                            \Filament\Schemas\Components\Fieldset::make('Lanjutan Penelitian')
                                ->schema([
                                    \Filament\Forms\Components\Select::make('proposal_revision_status')->label('6) Perbaikan / Revisi Proposal')->options(['approved' => 'Approved', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                    \Filament\Forms\Components\Select::make('research_implementation_status')->label('7) Pelaksanaan Penelitian')->options(['finish' => 'Finish', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                    \Filament\Forms\Components\Select::make('data_collection_status')->label('8) Pengumpulan Data')->options(['finish' => 'Finish', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                    \Filament\Forms\Components\Select::make('data_analysis_status')->label('9) Analisis Data')->options(['finish' => 'Finish', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                    \Filament\Forms\Components\Select::make('thesis_writing_status')->label('10) Penulisan Tesis')->options(['finish' => 'Finish', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                ])->columns(2),
                            \Filament\Schemas\Components\Fieldset::make('Ujian Tesis Akhir')
                                ->schema([
                                    \Filament\Forms\Components\Select::make('thesis_exam_status')->label('11) Status Ujian Tesis')->options(['finish' => 'Finish', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                    \Filament\Forms\Components\DatePicker::make('thesis_exam_date')->label('12) Tanggal Ujian'),
                                    \Filament\Forms\Components\TextInput::make('thesis_exam_score')->label('13) Nilai Ujian'),
                                    \Filament\Forms\Components\Select::make('thesis_revision_status')->label('14) Perbaikan / Revisi Tesis')->options(['approved' => 'Approved', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                ])->columns(2),
                            \Filament\Schemas\Components\Fieldset::make('Publikasi Jurnal')
                                ->schema([
                                    \Filament\Forms\Components\Select::make('journal_article_status')->label('15) Penulisan Artikel Jurnal')->options(['finish' => 'Finish', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                    \Filament\Forms\Components\Select::make('journal_publication_status')->label('16) Publikasi Jurnal')->options(['finish' => 'Finish', 'on_process' => 'On Process', 'not_yet' => 'Not Yet']),
                                ])->columns(2),
                        ]),
                    \Filament\Schemas\Components\Tabs\Tab::make('Kegiatan Akademik Lainnya')
                        ->schema([
                            \Filament\Forms\Components\Repeater::make('other_academic_activities')
                                ->label('E. Kegiatan Akademik Lainnya')
                                ->schema([
                                    \Filament\Forms\Components\Select::make('jenis')
                                        ->label('Jenis Kegiatan')
                                        ->options(['Seminar' => 'Seminar', 'Workshop' => 'Workshop', 'Training' => 'Training'])
                                        ->required(),
                                    \Filament\Forms\Components\TextInput::make('nama')->label('Nama Kegiatan')->required(),
                                    \Filament\Forms\Components\TextInput::make('tanggal_tempat')->label('Tanggal / Tempat')->required(),
                                    \Filament\Forms\Components\FileUpload::make('sertifikat')->label('Sertifikat')->directory('certificates'),
                                ])->columns(2),
                        ]),
                    \Filament\Schemas\Components\Tabs\Tab::make('Status Laporan')
                        ->schema([
                            \Filament\Forms\Components\Select::make('status')
                                ->options([
                                    'submission' => 'Submission',
                                    'revisi' => 'Revisi',
                                    'approved' => 'Approved',
                                    'rejected' => 'Rejected',
                                ])
                                ->default('submission')
                                ->disabled(function() {
                                    $user = auth()->user();
                                    if ($user->hasRole('super_admin')) return false;
                                    if ($user->hasRole('pimpinan')) {
                                        $dirName = $user->direktorat ? strtolower($user->direktorat->name) : '';
                                        return strpos($dirName, 'human capital') === false;
                                    }
                                    return true;
                                })
                                ->dehydrated()
                                ->required()
                                ->reactive(),
                            
                            \Filament\Forms\Components\Textarea::make('notes_pimpinan')
                                ->label('Catatan Pimpinan (Wajib jika Revisi)')
                                ->rows(4)
                                ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('status') === 'revisi')
                                ->required(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('status') === 'revisi'),
                        ])
                        ->visible(fn() => auth()->user() && (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('mentor') || auth()->user()->hasRole('pimpinan'))),

                    \Filament\Schemas\Components\Tabs\Tab::make('Dokumen & Tanda Tangan')
                        ->schema([
                            \Filament\Schemas\Components\Fieldset::make('Sertifikat & Tanda Tangan')
                                ->schema([
                                    \Filament\Forms\Components\FileUpload::make('certificates')
                                        ->label('Sertifikat (PDF/Image)')
                                        ->multiple()
                                        ->directory('certificates')
                                        ->downloadable()
                                        ->openable()
                                        ->columnSpanFull()
                                        ->disabled(),
                                    \Filament\Forms\Components\FileUpload::make('signature_image')
                                        ->label('Tanda Tangan (Gambar Upload)')
                                        ->directory('signatures')
                                        ->image()
                                        ->disabled(),
                                    \Filament\Forms\Components\Placeholder::make('signature_pad')
                                        ->label('Tanda Tangan (Pad)')
                                        ->content(function ($record) {
                                            if ($record && $record->signature_pad) {
                                                return \Illuminate\Support\HtmlString::make('<img src="' . $record->signature_pad . '" style="max-height: 100px;">');
                                            }
                                            return '-';
                                        }),
                                ])->columns(2),
                        ]),
                ])
                ->columnSpanFull()
        ]);
    }
}
