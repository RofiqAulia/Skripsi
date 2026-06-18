<?php
/**
 * Test Document Upload Functionality
 * 
 * Cara pakai:
 * 1. Copy file PDF/DOC ke directory ini dengan nama test_file.pdf
 * 2. Run: php test_upload.php
 */

// Setup Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

echo "═══════════════════════════════════════════════\n";
echo "  DOCUMENT UPLOAD TEST\n";
echo "═══════════════════════════════════════════════\n\n";

// 1. Check storage directory
echo "[1] Checking storage directory...\n";
$storagePath = storage_path('app/public/documents');
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
    echo "✓ Created storage directory: $storagePath\n";
} else {
    echo "✓ Storage directory exists\n";
}

// 2. Check if user exists
echo "\n[2] Checking user...\n";
$user = User::first();
if (!$user) {
    echo "✗ No user found! Please create a user first.\n";
    exit(1);
}
echo "✓ Found user: {$user->name} (ID: {$user->id})\n";

// 3. Create test files
echo "\n[3] Creating test files...\n";

$testFiles = [
    'test_pdf.pdf' => 'Sample PDF content (simulated)',
    'test_doc.doc' => 'Sample DOC content (simulated)',
    'test_png.png' => 'Sample PNG content (simulated)',
];

foreach ($testFiles as $filename => $content) {
    $path = storage_path("app/temp/$filename");
    
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }
    
    file_put_contents($path, $content);
    echo "✓ Created temp file: $filename\n";
}

// 4. Test file upload
echo "\n[4] Testing file upload...\n";

// Simulate file upload
$testFile = storage_path('app/temp/test_pdf.pdf');

if (!file_exists($testFile)) {
    echo "✗ Test file not found: $testFile\n";
    exit(1);
}

// Create UploadedFile instance
$uploadedFile = new UploadedFile(
    $testFile,
    'test_pdf.pdf',
    'application/pdf',
    null,
    true // test mode
);

echo "✓ Created UploadedFile: {$uploadedFile->getClientOriginalName()}\n";
echo "  Size: {$uploadedFile->getSize()} bytes\n";
echo "  Type: {$uploadedFile->getMimeType()}\n";

// 5. Store file
echo "\n[5] Storing file to disk...\n";

$storagePath = 'documents/' . $user->id;
try {
    $path = $uploadedFile->store($storagePath, 'public');
    echo "✓ File stored successfully\n";
    echo "  Path: $path\n";
    echo "  Full path: " . storage_path("app/public/$path") . "\n";
} catch (\Exception $e) {
    echo "✗ Failed to store file: {$e->getMessage()}\n";
    exit(1);
}

// 6. Create database record
echo "\n[6] Creating database record...\n";

try {
    $document = Document::updateOrCreate(
        [
            'user_id'  => $user->id,
            'type'     => 'test_upload',
            'category' => 'required',
        ],
        [
            'file'        => $path,
            'status'      => 'uploaded',
            'notes'       => 'Test upload',
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]
    );
    
    echo "✓ Document record created/updated\n";
    echo "  ID: {$document->id}\n";
    echo "  User: {$document->user->name}\n";
    echo "  File: {$document->file}\n";
    echo "  Status: {$document->status}\n";
} catch (\Exception $e) {
    echo "✗ Failed to create document: {$e->getMessage()}\n";
    exit(1);
}

// 7. Verify file exists
echo "\n[7] Verifying file exists...\n";

$fullPath = storage_path("app/public/$path");
if (file_exists($fullPath)) {
    echo "✓ File verified at: $fullPath\n";
    echo "  Size: " . filesize($fullPath) . " bytes\n";
} else {
    echo "✗ File not found at: $fullPath\n";
    exit(1);
}

// 8. Cleanup
echo "\n[8] Cleaning up test files...\n";

foreach ($testFiles as $filename => $content) {
    $path = storage_path("app/temp/$filename");
    if (file_exists($path)) {
        unlink($path);
        echo "✓ Deleted: $filename\n";
    }
}

if (is_dir(storage_path("app/temp")) && count(glob(storage_path("app/temp") . '/*')) === 0) {
    rmdir(storage_path("app/temp"));
    echo "✓ Removed temp directory\n";
}

echo "\n═══════════════════════════════════════════════\n";
echo "✓ ALL TESTS PASSED!\n";
echo "═══════════════════════════════════════════════\n\n";

echo "Next steps:\n";
echo "1. Open browser and go to: http://localhost/document\n";
echo "2. Try uploading a file using the form\n";
echo "3. Check browser console (F12) for debug messages\n";
echo "4. Check admin panel to approve/reject the document\n\n";
