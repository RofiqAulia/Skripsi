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
            $userId = auth()->id();
            
            // Collect all allowed IDs for this user based on their leadership roles
            $allowedDepartmentIds = collect();
            $allowedGroupIds = collect();
            $allowedDirektoratIds = collect();

            // 1. Is user a Department Head?
            $deptIds = \App\Models\Department::where('head_id', $userId)->pluck('id');
            if ($deptIds->isNotEmpty()) {
                $allowedDepartmentIds = $allowedDepartmentIds->merge($deptIds);
                // Department head only sees stage 0 (submission) or higher
                // Actually they should see all apps from their department, but only can approve stage 0.
            }

            // 2. Is user a Group Head?
            $groupIds = \App\Models\Group::where('head_id', $userId)->pluck('id');
            if ($groupIds->isNotEmpty()) {
                $allowedGroupIds = $allowedGroupIds->merge($groupIds);
                $deptIdsFromGroups = \App\Models\Department::whereIn('group_id', $groupIds)->pluck('id');
                $allowedDepartmentIds = $allowedDepartmentIds->merge($deptIdsFromGroups);
            }

            // 3. Is user a Direktorat Head?
            $direktoratIds = \App\Models\Direktorat::where('head_id', $userId)->pluck('id');
            if ($direktoratIds->isNotEmpty()) {
                $allowedDirektoratIds = $allowedDirektoratIds->merge($direktoratIds);
                $groupIdsFromDir = \App\Models\Group::whereIn('direktorat_id', $direktoratIds)->pluck('id');
                $allowedGroupIds = $allowedGroupIds->merge($groupIdsFromDir);
                $deptIdsFromDir = \App\Models\Department::whereIn('group_id', $groupIdsFromDir)->pluck('id');
                $allowedDepartmentIds = $allowedDepartmentIds->merge($deptIdsFromDir);
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
