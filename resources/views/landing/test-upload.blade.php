@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Test Upload File</h5>
                </div>
                <div class="card-body">
                    
                    <!-- Info -->
                    <div class="alert alert-info">
                        <strong>Instruksi:</strong>
                        <ul class="mb-0">
                            <li>Pilih file (PDF, DOC, DOCX, JPG, PNG)</li>
                            <li>Maksimal ukuran: 10 MB</li>
                            <li>Buka Developer Console (F12) untuk melihat debug info</li>
                        </ul>
                    </div>

                    <!-- Upload Form -->
                    <form id="testUploadForm" action="{{ route('document.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="cv">
                        <input type="hidden" name="category" value="required">

                        <div class="form-group mb-3">
                            <label for="fileInput" class="form-label fw-bold">Pilih File:</label>
                            <input type="file" id="fileInput" name="file" class="form-control" required 
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="text-muted d-block mt-2">
                                File yang dipilih: <span id="selectedFile">-</span>
                            </small>
                        </div>

                        <div id="uploadProgress" class="mb-3 d-none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" 
                                     id="progressBar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <div id="uploadStatus" class="mb-3 d-none">
                            <div id="statusMessage"></div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-cloud-upload"></i> Upload File
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            Reset
                        </button>
                    </form>

                    <!-- Debug Info -->
                    <div class="mt-5">
                        <h6 class="fw-bold">Debug Information:</h6>
                        <div id="debugInfo" class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto; font-size: 12px;">
                            <small>Debug messages akan tampil di sini...</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const DEBUG = true;
const debugInfo = [];

function log(msg) {
    debugInfo.push('[' + new Date().toLocaleTimeString() + '] ' + msg);
    console.log(msg);
    updateDebugDisplay();
}

function updateDebugDisplay() {
    const el = document.getElementById('debugInfo');
    if (el) {
        el.innerHTML = '<small>' + debugInfo.join('<br>') + '</small>';
        el.scrollTop = el.scrollHeight;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    log('Page loaded');

    const form = document.getElementById('testUploadForm');
    const fileInput = document.getElementById('fileInput');
    const selectedFileSpan = document.getElementById('selectedFile');
    const submitBtn = document.getElementById('submitBtn');
    const uploadStatus = document.getElementById('uploadStatus');
    const statusMessage = document.getElementById('statusMessage');
    const progressDiv = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');

    // File input change event
    fileInput.addEventListener('change', function(e) {
        log('File input changed. Files: ' + e.target.files.length);
        
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            log('Selected file: ' + file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)');
            selectedFileSpan.textContent = file.name;
        } else {
            selectedFileSpan.textContent = '-';
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        log('Form submitted');

        if (!fileInput.files || !fileInput.files[0]) {
            log('ERROR: No file selected');
            showError('Please select a file');
            return;
        }

        const file = fileInput.files[0];
        log('Uploading file: ' + file.name);

        // Disable button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Uploading...';
        progressDiv.classList.remove('d-none');
        uploadStatus.classList.add('d-none');

        const formData = new FormData(form);
        
        log('FormData created, starting fetch...');
        log('Form action: ' + form.action);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => {
            log('Response status: ' + response.status);
            
            if (response.ok) {
                return response.json().then(data => {
                    log('Success! Response: ' + JSON.stringify(data));
                    return { success: true, data };
                });
            } else {
                return response.json().then(data => {
                    log('Error response: ' + JSON.stringify(data));
                    throw new Error(data.message || 'Upload failed with status ' + response.status);
                }).catch(() => {
                    throw new Error('Upload failed with status ' + response.status);
                });
            }
        })
        .then(result => {
            log('Upload successful!');
            showSuccess('File uploaded successfully! Redirecting in 3 seconds...');
            
            setTimeout(() => {
                window.location.href = '{{ route("document") }}';
            }, 3000);
        })
        .catch(error => {
            log('ERROR caught: ' + error.message);
            showError('Upload failed: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Upload File';
            progressDiv.classList.add('d-none');
        });
    });

    function showError(msg) {
        uploadStatus.classList.remove('d-none');
        statusMessage.innerHTML = '<div class="alert alert-danger">' + msg + '</div>';
    }

    function showSuccess(msg) {
        uploadStatus.classList.remove('d-none');
        statusMessage.innerHTML = '<div class="alert alert-success">' + msg + '</div>';
    }

    log('Setup complete, ready for upload');
});
</script>
@endsection
