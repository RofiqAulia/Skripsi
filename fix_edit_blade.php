<?php

$file = 'c:\laragon\www\skripsi-rpx\resources\views\study-progress-report\edit.blade.php';
$content = file_get_contents($file);

// 1. Replace simple inputs
$fields = [
    'semester',
    'gpa',
    'thesis_title',
    'thesis_proposal',
    'proposal_exam_date',
    'proposal_exam_score',
    'thesis_exam_date',
    'thesis_exam_score',
];

foreach ($fields as $f) {
    $content = str_replace(
        "value=\"{{ old('$f') }}\"",
        "value=\"{{ old('$f', \$latestReport->$f) }}\"",
        $content
    );
}

// 2. Replace selects
$selects = [
    'thesis_title_status',
    'thesis_proposal_status',
    'proposal_exam_status',
    'proposal_revision_status',
    'research_implementation_status',
    'data_collection_status',
    'data_analysis_status',
    'thesis_writing_status',
    'thesis_exam_status',
    'thesis_revision_status',
    'journal_article_status',
    'journal_publication_status',
];

foreach ($selects as $s) {
    $pattern = '/<select name="' . preg_quote($s, '/') . '" class="form-select">(.*?)<\/select>/s';
    $content = preg_replace_callback($pattern, function($m) use ($s) {
        $inner = $m[1];
        // For each <option value="xxx">, add {{ old('...', $latestReport->...) == 'xxx' ? 'selected' : '' }}
        $inner = preg_replace_callback('/<option value="([^"]+)">/', function($opt_m) use ($s) {
            $val = $opt_m[1];
            if ($val === '') {
                // The empty "select status" option
                return '<option value="" {{ old(\'' . $s . '\', $latestReport->' . $s . ') == \'\' ? \'selected\' : \'\' }}>';
            } else {
                return '<option value="' . $val . '" {{ old(\'' . $s . '\', $latestReport->' . $s . ') == \'' . $val . '\' ? \'selected\' : \'\' }}>';
            }
        }, $inner);
        return '<select name="' . $s . '" class="form-select">' . $inner . '</select>';
    }, $content);
}

// 3. Replace json_encode fields in JavaScript
$jsonFields = [
    'completed_courses_name' => "array_column(\$latestReport->completed_courses ?? [], 'course_name')",
    'completed_courses_credits' => "array_column(\$latestReport->completed_courses ?? [], 'credits')",
    'completed_courses_grade' => "array_column(\$latestReport->completed_courses ?? [], 'grade')",
    
    'ongoing_courses_name' => "array_column(\$latestReport->ongoing_courses ?? [], 'course_name')",
    'ongoing_courses_credits' => "array_column(\$latestReport->ongoing_courses ?? [], 'credits')",
    
    'upcoming_courses_name' => "array_column(\$latestReport->upcoming_courses ?? [], 'course_name')",
    'upcoming_courses_credits' => "array_column(\$latestReport->upcoming_courses ?? [], 'credits')",
    
    'activity_name' => "array_column(\$latestReport->other_academic_activities ?? [], 'activity_name')",
    'activity_date' => "array_column(\$latestReport->other_academic_activities ?? [], 'activity_date')",
    'activity_description' => "array_column(\$latestReport->other_academic_activities ?? [], 'description')",
];

foreach ($jsonFields as $k => $fallback) {
    $content = preg_replace(
        "/old\('$k', \[\]\)/",
        "old('$k', $fallback ?: [])",
        $content
    );
}

file_put_contents($file, $content);
echo "Done replacing.";

