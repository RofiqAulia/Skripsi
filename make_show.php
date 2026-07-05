<?php

$src = 'c:\laragon\www\skripsi-rpx\resources\views\study-progress-report\edit.blade.php';
$dst = 'c:\laragon\www\skripsi-rpx\resources\views\study-progress-report\show.blade.php';
$content = file_get_contents($src);

// Change titles
$content = str_replace('Submit Study Progress Report', 'View Study Progress Report', $content);
$content = str_replace('Edit / Revise Study Progress Report', 'Detail Study Progress Report', $content);

// Remove form
$content = preg_replace('#<form action="[^"]*" method="POST" enctype="multipart/form-data" id="studyProgressForm">#', '<div>', $content);
$content = str_replace('</form>', '</div>', $content);
$content = str_replace('@csrf', '', $content);
$content = str_replace('@method(\'PUT\')', '', $content);

// Make inputs disabled readonly
$content = preg_replace('/(<input [^>]+)>/i', '$1 disabled readonly>', $content);
$content = preg_replace('/(<select [^>]+)>/i', '$1 disabled>', $content);

// Remove Add and Delete buttons
$content = preg_replace('/<a href="javascript:void\(0\)" class="btn-add-row[^>]+>.*?<\/a>/is', '', $content);
$content = preg_replace('/<td class="text-center"><button type="button" class="btn-delete-row"[^>]*><i class="bi bi-trash3"><\/i><\/button><\/td>/', '', $content);

// Remove file inputs completely since we can only view existing ones
$content = preg_replace('/<input class="form-control" type="file"[^>]+disabled readonly>/is', '', $content);
// Clean up labels and text for file inputs
$content = str_replace('You can select multiple files. PDF or Image max 5MB. <strong class="text-danger">Note: Uploading new files will overwrite the currently saved files.</strong>', '', $content);
$content = str_replace('Boleh berupa PDF, Word, PPT, atau Gambar. <strong class="text-danger">Note: Uploading new files will overwrite the currently saved files.</strong>', '', $content);
$content = preg_replace('/<div class="form-text mt-2"><strong class="text-danger">Note: Uploading a new image will overwrite the currently saved signature image.<\/strong><\/div>/', '', $content);

// Fix the signature tab (remove draw tab, show only uploaded or existing)
$content = preg_replace('/<ul class="nav nav-pills.*?<\/ul>/is', '', $content);
$content = preg_replace('/<div class="tab-pane fade show active" id="pills-draw" role="tabpanel">.*?<\/div>\s*<div class="tab-pane fade" id="pills-upload" role="tabpanel">/is', '<div>', $content);
// The end div for pills-upload
// Actually it's easier to just remove the drawing canvas completely.
$content = preg_replace('/<div class="border rounded-3" style="background: #f8fafc; overflow: hidden; width: fit-content;">.*?<\/canvas>\s*<\/div>/is', '', $content);
$content = preg_replace('/<button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clear-signature">.*?<\/button>/is', '', $content);
$content = str_replace('You can either draw your signature below or upload an image.', 'Signature yang tersimpan.', $content);

// Change Submit to Back button
$content = preg_replace('/<button type="submit" class="btn-submit">.*?<\/button>/is', '', $content);
$content = str_replace('<a href="{{ route(\'dashboard\') }}" class="btn-cancel text-decoration-none">Cancel</a>', '<a href="{{ route(\'study-progress-report.index\') }}" class="btn-cancel text-decoration-none"><i class="bi bi-arrow-left me-2"></i> Back</a>', $content);

file_put_contents($dst, $content);
echo "Created show.blade.php\n";

