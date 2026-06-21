<?php
$files = [
    'app/Filament/Resources/Documents/DocumentResource.php',
    'app/Filament/Resources/Events/EventResource.php',
    'app/Filament/Resources/FinancialPlans/FinancialPlanResource.php',
    'app/Filament/Resources/Mentors/MentorResource.php',
    'app/Filament/Resources/ProgramStudies/ProgramStudyResource.php',
    'app/Filament/Resources/PspApplications/PspApplicationResource.php',
    'app/Filament/Resources/ScholarshipApplications/ScholarshipApplicationResource.php',
    'app/Filament/Resources/ScholarshipInsights/ScholarshipInsightResource.php',
    'app/Filament/Resources/Scholarships/ScholarshipResource.php',
    'app/Filament/Resources/StudyPlans/StudyPlanResource.php',
    'app/Filament/Resources/Users/UserResource.php',
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    if (strpos($content, 'public static function canViewAny(): bool') === false) {
        $insert = "\n    public static function canViewAny(): bool\n    {\n        return !auth()->user()->hasRole('mentor');\n    }\n";
        // Insert right before 'public static function form'
        $content = preg_replace('/(\s+)(public static function form)/', $insert . '$1$2', $content, 1);
        file_put_contents($file, $content);
        echo "Updated " . $file . PHP_EOL;
    } else {
        echo "Already has canViewAny: " . $file . PHP_EOL;
    }
}
