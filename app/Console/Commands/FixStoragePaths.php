<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Event;
use App\Models\ScholarshipInsight;
use App\Models\Scholarship;

class FixStoragePaths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-storage-paths';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Strip the storage/ prefix from all uploaded file paths in the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing storage paths in the database...');

        // Update Users (photo)
        $usersUpdated = DB::table('users')
            ->where('photo', 'like', 'storage/%')
            ->update([
                'photo' => DB::raw("SUBSTRING(photo, 9)") // 9 is length of 'storage/' + 1
            ]);
        $this->info("Updated {$usersUpdated} users.");

        // Update Mentors (photo)
        $mentorsUpdated = DB::table('mentors')
            ->where('photo', 'like', 'storage/%')
            ->update([
                'photo' => DB::raw("SUBSTRING(photo, 9)")
            ]);
        $this->info("Updated {$mentorsUpdated} mentors.");

        // Update Events (poster, attachment, maybe more? Let's assume poster for now)
        if (\Schema::hasColumn('events', 'poster')) {
            $eventsUpdated = DB::table('events')
                ->where('poster', 'like', 'storage/%')
                ->update([
                    'poster' => DB::raw("SUBSTRING(poster, 9)")
                ]);
            $this->info("Updated {$eventsUpdated} events.");
        }

        // Update Scholarship Insights (cover_image)
        if (\Schema::hasColumn('scholarship_insights', 'cover_image')) {
            $insightsUpdated = DB::table('scholarship_insights')
                ->where('cover_image', 'like', 'storage/%')
                ->update([
                    'cover_image' => DB::raw("SUBSTRING(cover_image, 9)")
                ]);
            $this->info("Updated {$insightsUpdated} scholarship insights.");
        }

        // Update other potential tables if necessary
        // You can add more tables and columns here following the same pattern.
        
        $this->info('Done fixing storage paths!');
    }
}
