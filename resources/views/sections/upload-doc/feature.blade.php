<section class="upload-section py-5">

<div class="container-lg">

    {{-- ═══════════════════════════════════════════════
        PROGRESS SUMMARY CARD
    ═══════════════════════════════════════════════ --}}
    <div class="doc-progress-card mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-1">Document Submission</h2>
                <p class="text-muted mb-3">Upload all required documents for your mentoring program application. Each document will be reviewed by the admin team.</p>

                <div class="progress-bar-wrapper">
                    @php
                        $pct = $totalRequired > 0 ? round(($approvedCount / $totalRequired) * 100) : 0;
                    @endphp
                    <div class="d-flex justify-content-between mb-1">
                        <span class="progress-label">{{ $approvedCount }} of {{ $totalRequired }} approved</span>
                        <span class="progress-label fw-semibold">{{ $pct }}%</span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 99px;">
                        <div class="progress-bar progress-bar-animated
                            @if($pct === 100) bg-success @elseif($pct >= 50) bg-warning @else bg-danger @endif"
                             role="progressbar"
                             style="width: {{ $pct }}%"
                             aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="stat-circle mx-auto mx-md-0 ms-md-auto">
                    <span class="stat-number">{{ $pct }}%</span>
                    <span class="stat-label">Complete</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
        DOCUMENTS TABLE
    ═══════════════════════════════════════════════ --}}
    <div class="table-responsive">
        <table class="table align-middle upload-table" id="documents-table">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th style="width:30%">Document Name</th>
                    <th style="width:20%">Status</th>
                    <th style="width:25%">Admin Notes</th>
                    <th style="width:20%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documentTypes as $index => $item)
                <tr class="doc-row" data-status="{{ $item->status }}">
                    {{-- # --}}
                    <td class="fw-semibold text-muted">{{ $loop->iteration }}</td>

                    {{-- Document Name --}}
                    <td>
                        <div class="doc-name">
                            <i class="bi {{ match($item->type) {
                                'cv'                => 'bi-person-lines-fill',
                                'motivation_letter' => 'bi-envelope-paper-fill',
                                'ielts_toefl'       => 'bi-translate',
                                'transcript'        => 'bi-journal-bookmark-fill',
                                'psp'               => 'bi-clipboard-check-fill',
                                default             => 'bi-file-earmark-text-fill'
                            } }} doc-icon"></i>
                            <div>
                                <strong>{{ $item->label }}</strong>
                                @if($item->type === 'psp')
                                    <span class="badge bg-dark ms-1" style="font-size:10px">Mandatory</span>
                                @endif
                                @if($item->reviewed_at)
                                    <br><small class="text-muted">Reviewed {{ $item->reviewed_at->diffForHumans() }}</small>
                                @elseif($item->document)
                                    <br><small class="text-muted">Uploaded {{ $item->document->updated_at->diffForHumans() }}</small>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Status Badge --}}
                    <td>
                        @switch($item->status)
                            @case('not_uploaded')
                                <span class="badge badge-status badge-not-uploaded">
                                    <i class="bi bi-cloud-arrow-up me-1"></i>Not Uploaded
                                </span>
                                @break
                            @case('uploaded')
                                <span class="badge badge-status badge-pending">
                                    <i class="bi bi-hourglass-split me-1"></i>Awaiting Review
                                </span>
                                @break
                            @case('approved')
                                <span class="badge badge-status badge-approved">
                                    <i class="bi bi-check-circle-fill me-1"></i>Approved
                                </span>
                                @break
                            @case('revisi')
                                <span class="badge badge-status badge-rejected">
                                    <i class="bi bi-x-circle-fill me-1"></i>Revision
                                </span>
                                @break
                        @endswitch
                    </td>

                    {{-- Admin Notes --}}
                    <td>
                        @if($item->notes)
                            <div class="admin-notes @if($item->status === 'revisi') notes-rejected @else notes-approved @endif">
                                <i class="bi bi-chat-left-text me-1"></i>
                                {{ $item->notes }}
                            </div>
                        @else
                            <span class="text-muted fst-italic" style="font-size:13px">—</span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="action-buttons">
                            {{-- Upload / Re-upload --}}
                            @if($item->status !== 'approved')
                                <button type="button"
                                        class="btn btn-sm btn-upload"
                                        data-bs-toggle="modal"
                                        data-bs-target="#uploadModal-{{ $item->type }}"
                                        title="{{ $item->status === 'not_uploaded' ? 'Upload' : 'Re-upload' }}">
                                    <i class="bi bi-cloud-upload-fill"></i>
                                    {{ $item->status === 'not_uploaded' ? 'Upload' : 'Re-upload' }}
                                </button>
                            @endif

                            {{-- View File --}}
                            @if($item->file)
                                <a href="{{ asset($item->file) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-view"
                                   title="View Document">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                </a>
                            @endif

                            {{-- Delete (only if not approved) --}}
                            @if($item->document && $item->status !== 'approved')
                                <form action="{{ route('document.destroy', $item->document->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this document?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete" title="Delete">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>

                {{-- UPLOAD MODAL for each document type --}}
                <div class="modal fade" id="uploadModal-{{ $item->type }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content upload-modal-content">
                            <form action="{{ route('document.upload') }}" method="POST" enctype="multipart/form-data" class="upload-form" data-document-type="{{ $item->type }}">
                                @csrf
                                <input type="hidden" name="type" value="{{ $item->type }}">
                                <input type="hidden" name="category" value="required">

                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title fw-bold">
                                            <i class="bi bi-cloud-upload me-2"></i>Upload {{ $item->label }}
                                        </h5>
                                        <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG • Max 10 MB</small>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    {{-- Error Messages --}}
                                    <div class="error-container d-none" id="error-{{ $item->type }}">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                                            <strong>Upload Error</strong>
                                            <div class="error-message mt-2" id="error-message-{{ $item->type }}"></div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    </div>

                                    @if($item->status === 'revisi' && $item->notes)
                                        <div class="alert alert-danger d-flex align-items-start">
                                            <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                            <div>
                                                <strong>Rejection reason:</strong><br>
                                                {{ $item->notes }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="upload-dropzone" id="dropzone-{{ $item->type }}" data-document-type="{{ $item->type }}">
                                        <input type="file" name="file" id="file-{{ $item->type }}"
                                               class="upload-input" required
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <div class="dropzone-content text-center" id="dropzone-content-{{ $item->type }}">
                                            <i class="bi bi-cloud-arrow-up dropzone-icon mb-2" style="font-size: 32px; color: #4b5563;"></i>
                                            <p class="mb-1 fw-semibold text-dark" style="font-size: 15px;">Choose a file or drag & drop it here</p>
                                            <p class="text-muted mb-3" style="font-size: 13px;">JPEG, PNG, PDF, and DOCX formats, up to 10MB</p>
                                            <span class="btn btn-outline-secondary btn-sm px-4 rounded-3" style="pointer-events: none; z-index: 1; position: relative;">Browse File</span>
                                        </div>
                                    </div>

                                    {{-- Selected File Card --}}
                                    <div class="selected-file-card d-none mt-3" id="file-card-{{ $item->type }}">
                                        <div class="d-flex align-items-center p-3 border rounded-3" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                                            <div class="file-icon-box me-3">
                                                <i class="bi bi-file-earmark-text-fill fs-3" id="file-icon-{{ $item->type }}" style="color: #64748b;"></i>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h6 class="mb-0 text-truncate fw-semibold" id="fileName-{{ $item->type }}" style="font-size: 14px; color: #334155;"></h6>
                                                <small class="text-muted" id="file-size-{{ $item->type }}" style="font-size: 12px;"></small>
                                            </div>
                                            <button type="button" class="btn-close ms-2" aria-label="Remove" onclick="removeSelectedFile('{{ $item->type }}')" style="font-size: 12px; z-index: 10;"></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-submit-doc" id="submit-btn-{{ $item->type }}">
                                        <i class="bi bi-send-fill me-1"></i><span class="btn-text">Submit Document</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ═══════════════════════════════════════════════
        OPTIONAL: Other Supporting Documents
    ═══════════════════════════════════════════════ --}}
    <div class="other-docs-section mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-0">Other Supporting Documents</h5>
                <small class="text-muted">Optional — upload additional certificates, recommendation letters, etc.</small>
            </div>
            <button type="button" class="btn btn-sm btn-upload" data-bs-toggle="modal" data-bs-target="#uploadModal-other">
                <i class="bi bi-plus-lg me-1"></i>Add Document
            </button>
        </div>

        @if($otherDocuments->count() > 0)
            <div class="row g-3">
                @foreach($otherDocuments as $otherDoc)
                    <div class="col-md-4">
                        <div class="other-doc-card">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-file-earmark-text-fill text-primary" style="font-size:24px"></i>
                                    <div>
                                        <strong style="font-size:13px">{{ basename($otherDoc->file) }}</strong>
                                        <br>
                                        <span class="badge badge-status
                                            @if($otherDoc->status === 'approved') badge-approved
                                            @elseif($otherDoc->status === 'revisi') badge-rejected
                                            @else badge-pending @endif"
                                            style="font-size:10px">
                                            {{ ucfirst($otherDoc->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ asset($otherDoc->file) }}" target="_blank" class="btn btn-sm btn-view" title="View">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    </a>
                                    @if($otherDoc->status !== 'approved')
                                        <form action="{{ route('document.destroy', $otherDoc->id) }}" method="POST"
                                              onsubmit="return confirm('Delete this document?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-delete"><i class="bi bi-trash3-fill"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            @if($otherDoc->notes)
                                <div class="admin-notes mt-2 @if($otherDoc->status === 'revisi') notes-rejected @else notes-approved @endif" style="font-size:12px">
                                    <i class="bi bi-chat-left-text me-1"></i>{{ $otherDoc->notes }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted py-4" style="font-size:14px">
                <i class="bi bi-folder2-open" style="font-size:32px"></i>
                <p class="mt-2 mb-0">No additional documents uploaded yet.</p>
            </div>
        @endif

        {{-- Upload Modal for Other Documents --}}
        <div class="modal fade" id="uploadModal-other" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content upload-modal-content">
                    <form action="{{ route('document.upload') }}" method="POST" enctype="multipart/form-data" class="upload-form" data-document-type="other">
                        @csrf
                        <input type="hidden" name="type" value="other">
                        <input type="hidden" name="category" value="other">

                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title fw-bold">
                                    <i class="bi bi-cloud-upload me-2"></i>Upload Supporting Document
                                </h5>
                                <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG • Max 10 MB</small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            {{-- Error Messages --}}
                            <div class="error-container d-none" id="error-other">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <strong>Upload Error</strong>
                                    <div class="error-message mt-2" id="error-message-other"></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            </div>

                            <div class="upload-dropzone" id="dropzone-other" data-document-type="other">
                                <input type="file" name="file[]" id="file-other"
                                       class="upload-input" required multiple
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <div class="dropzone-content text-center" id="dropzone-content-other">
                                    <i class="bi bi-cloud-arrow-up dropzone-icon mb-2" style="font-size: 32px; color: #4b5563;"></i>
                                    <p class="mb-1 fw-semibold text-dark" style="font-size: 15px;">Choose a file or drag & drop it here</p>
                                    <p class="text-muted mb-3" style="font-size: 13px;">JPEG, PNG, PDF, and DOCX formats, up to 10MB</p>
                                    <span class="btn btn-outline-secondary btn-sm px-4 rounded-3" style="pointer-events: none; z-index: 1; position: relative;">Browse File</span>
                                </div>
                            </div>

                            {{-- Selected File Card --}}
                            <div class="selected-file-card d-none mt-3" id="file-card-other">
                                <div class="d-flex align-items-center p-3 border rounded-3" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                                    <div class="file-icon-box me-3">
                                        <i class="bi bi-file-earmark-text-fill fs-3" id="file-icon-other" style="color: #64748b;"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-0 text-truncate fw-semibold" id="fileName-other" style="font-size: 14px; color: #334155;"></h6>
                                        <small class="text-muted" id="file-size-other" style="font-size: 12px;"></small>
                                    </div>
                                    <button type="button" class="btn-close ms-2" aria-label="Remove" onclick="removeSelectedFile('other')" style="font-size: 12px; z-index: 10;"></button>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-submit-doc" id="submit-btn-other">
                                <i class="bi bi-send-fill me-1"></i><span class="btn-text">Submit Document</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════
    STYLES
═══════════════════════════════════════════════ --}}
<style>

/* ─── PROGRESS CARD ─── */
.doc-progress-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fb 100%);
    border: 1px solid rgba(0,0,0,0.06);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.04);
}

.progress-label {
    font-size: 13px;
    color: #6b7280;
}

.stat-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8b0000, #b91c1c);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 8px 24px rgba(139,0,0,0.25);
}

.stat-number {
    font-size: 24px;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    font-size: 11px;
    opacity: 0.85;
    margin-top: 2px;
}

/* ─── TABLE ─── */
.upload-table {
    border-collapse: separate;
    border-spacing: 0 8px;
}

.upload-table thead th {
    border: none;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #9ca3af;
    font-weight: 600;
    padding: 8px 18px;
}

.upload-table tbody tr {
    background: #fff;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.upload-table tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

.upload-table td {
    padding: 16px 18px;
    border: none;
    vertical-align: middle;
}

.upload-table td:first-child {
    border-radius: 12px 0 0 12px;
}

.upload-table td:last-child {
    border-radius: 0 12px 12px 0;
}

/* Row accents by status */
.doc-row[data-status="approved"] {
    border-left: 4px solid #10b981;
}
.doc-row[data-status="revisi"] {
    border-left: 4px solid #ef4444;
}
.doc-row[data-status="uploaded"] {
    border-left: 4px solid #f59e0b;
}
.doc-row[data-status="not_uploaded"] {
    border-left: 4px solid #d1d5db;
}

/* ─── DOCUMENT NAME ─── */
.doc-name {
    display: flex;
    align-items: center;
    gap: 12px;
}

.doc-icon {
    font-size: 22px;
    color: #8b0000;
    opacity: 0.8;
}

/* ─── STATUS BADGES ─── */
.badge-status {
    padding: 6px 12px;
    font-weight: 500;
    font-size: 12px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
}

.badge-not-uploaded {
    background: rgba(156,163,175,0.12);
    color: #6b7280;
}

.badge-pending {
    background: rgba(245,158,11,0.12);
    color: #d97706;
}

.badge-approved {
    background: rgba(16,185,129,0.12);
    color: #059669;
}

.badge-rejected {
    background: rgba(239,68,68,0.12);
    color: #dc2626;
}

/* ─── ADMIN NOTES ─── */
.admin-notes {
    font-size: 13px;
    padding: 8px 12px;
    border-radius: 8px;
    line-height: 1.4;
}

.notes-rejected {
    background: rgba(239,68,68,0.06);
    color: #b91c1c;
    border-left: 3px solid #ef4444;
}

.notes-approved {
    background: rgba(16,185,129,0.06);
    color: #047857;
    border-left: 3px solid #10b981;
}

/* ─── ACTION BUTTONS ─── */
.action-buttons {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.btn-upload {
    background: linear-gradient(135deg, #8b0000, #b91c1c);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    padding: 6px 14px;
    transition: all 0.2s;
}

.btn-upload:hover {
    background: linear-gradient(135deg, #6d0000, #991b1b);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139,0,0,0.3);
}

.btn-view {
    background: rgba(59,130,246,0.1);
    color: #2563eb;
    border: none;
    border-radius: 8px;
    padding: 6px 10px;
    transition: all 0.2s;
}

.btn-view:hover {
    background: rgba(59,130,246,0.2);
    color: #1d4ed8;
}

.btn-delete {
    background: rgba(239,68,68,0.1);
    color: #dc2626;
    border: none;
    border-radius: 8px;
    padding: 6px 10px;
    transition: all 0.2s;
}

.btn-delete:hover {
    background: rgba(239,68,68,0.2);
    color: #b91c1c;
}

/* ─── UPLOAD MODAL ─── */
.upload-modal-content {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.upload-modal-content .modal-header {
    background: linear-gradient(135deg, #fafafa, #f5f5f5);
    border-bottom: 1px solid rgba(0,0,0,0.06);
    padding: 20px 24px;
}

.upload-modal-content .modal-body {
    padding: 24px;
}

.upload-modal-content .modal-footer {
    border-top: 1px solid rgba(0,0,0,0.06);
    padding: 16px 24px;
}

.error-container {
    margin-bottom: 16px;
}

.error-container.d-none {
    display: none !important;
}

.error-message {
    font-size: 13px;
    line-height: 1.5;
}

.upload-dropzone {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #ffffff;
}

.upload-dropzone:hover, .upload-dropzone.dragover {
    border-color: #94a3b8;
    background: #f8fafc;
}

.upload-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.dropzone-icon {
    font-size: 48px;
    color: #8b0000;
    opacity: 0.4;
    display: block;
    margin-bottom: 8px;
}

.dropzone-preview {
    padding: 20px;
}

.dropzone-preview.d-none {
    display: none !important;
}

.file-name-display {
    font-size: 13px;
    word-break: break-all;
    color: #047857;
}

.btn-submit-doc {
    background: linear-gradient(135deg, #8b0000, #b91c1c);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    padding: 8px 20px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-submit-doc:hover:not(:disabled) {
    background: linear-gradient(135deg, #6d0000, #991b1b);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139,0,0,0.3);
}

.btn-submit-doc:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}

.spinner-border {
    width: 1em;
    height: 1em;
}

/* ─── OTHER DOCS ─── */
.other-docs-section {
    background: #fafbfc;
    border: 1px solid rgba(0,0,0,0.06);
    border-radius: 16px;
    padding: 24px;
}

.other-doc-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.06);
    border-radius: 12px;
    padding: 16px;
    transition: all 0.2s;
}

.other-doc-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}

/* ─── RESPONSIVE ─── */
@media (max-width: 768px) {
    .doc-progress-card { padding: 20px; }
    .stat-circle { width: 80px; height: 80px; }
    .stat-number { font-size: 20px; }
    .upload-table { font-size: 14px; }
    .action-buttons { flex-direction: column; }
}

</style>

<!-- BOOTSTRAP ICONS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

{{-- ═══════════════════════════════════════════════
    JAVASCRIPT
═══════════════════════════════════════════════ --}}
<script>
// Configuration
const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10 MB
const ALLOWED_EXTENSIONS = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

// ============================================
// MAIN INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('[Upload System] Initializing...');
    
    // Check for success message from previous upload
    const successMsg = localStorage.getItem('uploadSuccessMessage');
    if (successMsg) {
        showGlobalSuccessAlert(successMsg);
        localStorage.removeItem('uploadSuccessMessage');
    }
    
    // Wait a bit for all DOM elements to be fully loaded
    setTimeout(() => {
        setupAllForms();
        setupAllDropzones();
        console.log('[Upload System] Ready!');
        console.log('[Upload System] Found', document.querySelectorAll('.upload-form').length, 'forms');
        console.log('[Upload System] Found', document.querySelectorAll('.upload-dropzone').length, 'dropzones');
    }, 100);
});

function showGlobalSuccessAlert(message) {
    let container = document.querySelector('.custom-alerts-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'custom-alerts-container';
        document.body.appendChild(container);
    }
    
    const alertHtml = `
        <div class="custom-alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="alert-content">
                <strong>Success!</strong> ${message}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', alertHtml);
    
    setTimeout(() => {
        const alerts = container.querySelectorAll('.custom-alert');
        if (typeof bootstrap !== 'undefined') {
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }
    }, 5000);
}

// ============================================
// FORM SETUP
// ============================================

function setupAllForms() {
    document.querySelectorAll('.upload-form').forEach(form => {
        const docType = form.dataset.documentType;
        const fileInput = form.querySelector('input[type="file"]');
        const submitBtn = form.querySelector('button[type="submit"]');
        
        if (!fileInput) return;
        
        // File input change - CRITICAL EVENT
        fileInput.addEventListener('change', function() {
            onFileSelected(docType);
        });
        
        // Form submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            uploadFile(form, docType);
        });
    });
}

// ============================================
// DROPZONE SETUP
// ============================================

function setupAllDropzones() {
    document.querySelectorAll('.upload-dropzone').forEach(dropzone => {
        const docType = dropzone.dataset.documentType;
        const fileInput = dropzone.querySelector('.upload-input');
        
        if (!fileInput) return;
        
        // Note: The file input natively handles clicks since it covers the dropzone.
        // The 'change' event listener is already attached in setupAllForms().
        
        // Drag and drop
        setupDragAndDrop(dropzone, fileInput, docType);
    });
}

// ============================================
// DRAG & DROP
// ============================================

function setupDragAndDrop(dropzone, fileInput, docType) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    dropzone.addEventListener('dragenter', () => {
        dropzone.style.borderColor = '#8b0000';
        dropzone.style.backgroundColor = 'rgba(139,0,0,0.05)';
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.style.borderColor = '#d1d5db';
        dropzone.style.backgroundColor = '#fafafa';
    });

    dropzone.addEventListener('drop', (e) => {
        dropzone.style.borderColor = '#d1d5db';
        dropzone.style.backgroundColor = '#fafafa';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            // Use DataTransfer to properly set files
            const dt = new DataTransfer();
            dt.items.add(files[0]);
            fileInput.files = dt.files;
            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
}

// ============================================
// FILE SELECTION HANDLER
// ============================================

function onFileSelected(docType) {
    const fileInput = document.querySelector(`input[data-document-type="${docType}"]`) || 
                      document.querySelector(`[data-document-type="${docType}"] .upload-input`);
    
    if (!fileInput || !fileInput.files[0]) {
        clearFilePreview(docType);
        return;
    }

    // Validate ALL files
    for (let i = 0; i < fileInput.files.length; i++) {
        const validation = validateFile(fileInput.files[i]);
        if (!validation.valid) {
            showError(docType, `File ${i+1}: ` + validation.error);
            fileInput.value = '';
            clearFilePreview(docType);
            return;
        }
    }
    
    // Files are valid - show preview
    clearError(docType);
    showFilePreview(docType, fileInput.files);
}

// ============================================
// FILE VALIDATION
// ============================================

function validateFile(file) {
    // Check size
    if (file.size > MAX_FILE_SIZE) {
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        return {
            valid: false,
            error: `File size ${sizeMB} MB exceeds 10 MB limit.`
        };
    }

    // Check extension
    const ext = file.name.split('.').pop().toLowerCase();
    if (!ALLOWED_EXTENSIONS.includes(ext)) {
        return {
            valid: false,
            error: `File type .${ext} is not allowed. Use: PDF, DOC, DOCX, JPG, PNG.`
        };
    }

    return { valid: true };
}

// ============================================
// UI UPDATES
// ============================================

function showFilePreview(docType, files) {
    const cardEl = document.getElementById(`file-card-${docType}`);
    const nameEl = document.getElementById(`fileName-${docType}`);
    const sizeEl = document.getElementById(`file-size-${docType}`);
    const iconEl = document.getElementById(`file-icon-${docType}`);

    if (files.length === 1) {
        const file = files[0];
        if (nameEl) nameEl.textContent = file.name;
        if (sizeEl) sizeEl.textContent = formatFileSize(file.size);
        
        // Set appropriate icon based on extension
        if (iconEl) {
            const ext = file.name.split('.').pop().toLowerCase();
            let iconClass = 'bi-file-earmark-text-fill';
            let iconColor = '#64748b';
            
            if (ext === 'pdf') {
                iconClass = 'bi-file-earmark-pdf-fill';
                iconColor = '#ef4444';
            } else if (['jpg', 'jpeg', 'png'].includes(ext)) {
                iconClass = 'bi-file-earmark-image-fill';
                iconColor = '#10b981';
            } else if (['doc', 'docx'].includes(ext)) {
                iconClass = 'bi-file-earmark-word-fill';
                iconColor = '#3b82f6';
            }
            
            iconEl.className = `bi ${iconClass} fs-3`;
            iconEl.style.color = iconColor;
        }
    } else {
        if (nameEl) nameEl.textContent = `${files.length} files selected`;
        let totalSize = 0;
        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;
        }
        if (sizeEl) sizeEl.textContent = formatFileSize(totalSize);
        
        if (iconEl) {
            iconEl.className = 'bi bi-files fs-3';
            iconEl.style.color = '#3b82f6';
        }
    }
    
    if (cardEl) cardEl.classList.remove('d-none');
}

function clearFilePreview(docType) {
    const cardEl = document.getElementById(`file-card-${docType}`);
    if (cardEl) cardEl.classList.add('d-none');
}

function removeSelectedFile(docType) {
    const fileInput = document.getElementById(`file-${docType}`);
    if (fileInput) {
        fileInput.value = '';
        fileInput.dispatchEvent(new Event('change', { bubbles: true }));
    }
    clearError(docType);
    clearFilePreview(docType);
}

function showError(docType, message) {
    console.error(`[${docType}] Error: ${message}`);
    const container = document.getElementById(`error-${docType}`);

    if (container) {
        container.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <strong>Upload Error</strong>
                <div class="mt-1" style="font-size: 13px;">${message}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        container.classList.remove('d-none');
        container.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function clearError(docType) {
    const container = document.getElementById(`error-${docType}`);
    if (container) {
        container.innerHTML = '';
        container.classList.add('d-none');
    }
}

// ============================================
// FILE UPLOAD
// ============================================

function uploadFile(form, docType) {
    const fileInput = form.querySelector('input[type="file"]');
    const submitBtn = form.querySelector('button[type="submit"]');

    if (!fileInput.files[0]) {
        showError(docType, 'Please select a file');
        return;
    }

    // Validate all files before upload
    for (let i = 0; i < fileInput.files.length; i++) {
        const validation = validateFile(fileInput.files[i]);
        if (!validation.valid) {
            showError(docType, `File ${i+1}: ` + validation.error);
            return;
        }
    }

    // Show loading
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('[Upload] Response status:', response.status);
        console.log('[Upload] Response:', response);
        
        // Try to parse as JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(data => ({
                status: response.status,
                data: data
            }));
        } else {
            // If not JSON, just get the text
            return response.text().then(text => ({
                status: response.status,
                data: { message: text }
            }));
        }
    })
    .then(({ status, data }) => {
        if (status === 200 || status === 201) {
            clearError(docType);
            showSuccess(docType, 'Upload successful! Reloading...');
            
            // Set localStorage so success message persists after reload
            localStorage.setItem('uploadSuccessMessage', data.message || 'Document uploaded successfully!');
            
            setTimeout(() => window.location.reload(), 1500);
        } else {
            // `data` is already parsed above — use it directly
            const errorMsg = (data.errors && data.errors.file && data.errors.file[0])
                           || data.message
                           || 'Upload failed. Please try again.';
            throw new Error(errorMsg);
        }
    })
    .catch(error => {
        console.error('[Upload] Error:', error);
        showError(docType, `Upload failed: ${error.message || 'Unknown error'}`);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function showSuccess(docType, message) {
    const container = document.getElementById(`error-${docType}`);

    if (container) {
        container.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Success!</strong>
                <div class="mt-1" style="font-size: 13px;">${message}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        container.classList.remove('d-none');
    }
}

// ============================================
// UTILITIES
// ============================================

function formatFileSize(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}



</script>

</section>