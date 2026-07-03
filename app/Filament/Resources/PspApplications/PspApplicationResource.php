<?php

namespace App\Filament\Resources\PspApplications;

use App\Filament\Resources\PspApplications\Pages\CreatePspApplication;
use App\Filament\Resources\PspApplications\Pages\EditPspApplication;
use App\Filament\Resources\PspApplications\Pages\ListPspApplications;
use App\Filament\Resources\PspApplications\Schemas\PspApplicationForm;
use App\Filament\Resources\PspApplications\Tables\PspApplicationsTable;
use App\Models\PspApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PspApplicationResource extends Resource
{
    protected static ?string $model = PspApplication::class;

    protected static string | UnitEnum | null $navigationGroup = 'Study & Scholarship';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;


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
        } elseif (auth()->check() && !auth()->user()->hasRole('super_admin')) {
            $user = auth()->user();
            
            // Collect all allowed IDs for this user based on their leadership roles
            $allowedDepartmentIds = collect();
            $allowedGroupIds = collect();
            $allowedDirektoratIds = collect();

            if ($user->hasRole('pimpinan')) {
                if ($user->department_id) {
                    // 1. Is user a Department Head?
                    $allowedDepartmentIds->push($user->department_id);
                } elseif ($user->group_id) {
                    // 2. Is user a Group Head?
                    $allowedGroupIds->push($user->group_id);
                    $deptIdsFromGroups = \App\Models\Department::where('group_id', $user->group_id)->pluck('id');
                    $allowedDepartmentIds = $allowedDepartmentIds->merge($deptIdsFromGroups);
                } elseif ($user->direktorat_id) {
                    // 3. Is user a Direktorat Head?
                    $allowedDirektoratIds->push($user->direktorat_id);
                    $groupIdsFromDir = \App\Models\Group::where('direktorat_id', $user->direktorat_id)->pluck('id');
                    $allowedGroupIds = $allowedGroupIds->merge($groupIdsFromDir);
                    $deptIdsFromDir = \App\Models\Department::whereIn('group_id', $groupIdsFromDir)->pluck('id');
                    $allowedDepartmentIds = $allowedDepartmentIds->merge($deptIdsFromDir);
                }
            }

            if ($allowedDepartmentIds->isNotEmpty() || $allowedGroupIds->isNotEmpty() || $allowedDirektoratIds->isNotEmpty()) {
                $query->whereHas('user', function ($q) use ($allowedDepartmentIds, $allowedGroupIds, $allowedDirektoratIds) {
                    $q->where(function($subQ) use ($allowedDepartmentIds, $allowedGroupIds, $allowedDirektoratIds) {
                        if ($allowedDepartmentIds->isNotEmpty()) {
                            $subQ->orWhereIn('department_id', $allowedDepartmentIds->unique());
                        }
                        if ($allowedGroupIds->isNotEmpty()) {
                            $subQ->orWhereIn('group_id', $allowedGroupIds->unique());
                        }
                        if ($allowedDirektoratIds->isNotEmpty()) {
                            $subQ->orWhereIn('direktorat_id', $allowedDirektoratIds->unique());
                        }
                    });
                });
            } else {
                // If not a leader of any level and not super_admin, they see nothing
                // (or only their own if they are a regular user, but regular users don't access filament panel usually)
                if (auth()->user()->hasRole('pimpinan')) {
                    $query->where('id', 0);
                }
            }
        }
        
        return $query;
    }


    public static function form(Schema $schema): Schema
    {
        return PspApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PspApplicationsTable::configure($table);
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
            'index' => ListPspApplications::route('/'),
            'create' => CreatePspApplication::route('/create'),
            'edit' => EditPspApplication::route('/{record}/edit'),
        ];
    }
}
