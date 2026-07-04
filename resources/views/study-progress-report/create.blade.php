@extends('layouts.app')

@section('content')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
    :root {
        --primary-color: #b71c1c;
        --primary-light: #d32f2f;
        --bg-color: #f8fafc;
        --card-bg: rgba(255, 255, 255, 0.95);
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: var(--text-main);
    }

    .page-title {
        font-weight: 800;
        font-size: 2.2rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        font-weight: 400;
        margin-bottom: 2.5rem;
    }

    .glass-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 2rem;
    }

    .glass-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05), 0 3px 6px rgba(0,0,0,0.04);
    }

    .card-header-modern {
        background: linear-gradient(135deg, rgba(183, 28, 28, 0.03), rgba(211, 47, 47, 0.03));
        border-bottom: 1px solid var(--border-color);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header-modern h5 {
        margin: 0;
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
        letter-spacing: 0.2px;
    }

    .card-header-icon {
        background: rgba(183, 28, 28, 0.1);
        color: var(--primary-color);
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .card-body-modern {
        padding: 1.5rem;
    }

    /* Readonly Data Styling */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.25rem;
    }
    
    .info-item {
        background: rgba(241, 245, 249, 0.5);
        padding: 1rem;
        border-radius: 12px;
        border: 1px dashed rgba(203, 213, 225, 0.8);
    }
    
    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.95rem;
    }

    /* Form Controls */
    .form-label {
        font-weight: 600;
        color: #334155;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background-color: #ffffff;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.1);
        background-color: #ffffff;
    }

    /* Table Styling */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        margin-bottom: 1.5rem;
    }

    .modern-table thead {
        background: #f8fafc;
    }

    .modern-table th {
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .modern-table td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .modern-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .modern-table .form-control {
        border: 1px solid transparent;
        background: #f1f5f9;
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
    }

    .modern-table .form-control:focus {
        border-color: var(--primary-light);
        background: #ffffff;
    }

    .btn-add-row {
        background: rgba(183, 28, 28, 0.08);
        color: var(--primary-color);
        border: 1px dashed rgba(183, 28, 28, 0.3);
        border-radius: 8px;
        padding: 0.6rem 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        width: 100%;
        text-align: center;
        display: inline-block;
    }

    .btn-add-row:hover {
        background: rgba(183, 28, 28, 0.15);
        color: var(--primary-color);
        text-decoration: none;
        border-color: rgba(183, 28, 28, 0.5);
    }

    .btn-delete-row {
        background: #fee2e2;
        color: #ef4444;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-delete-row:hover {
        background: #ef4444;
        color: white;
    }

    /* Action Buttons */
    .btn-submit {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.8rem 2rem;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(183, 28, 28, 0.25);
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(183, 28, 28, 0.35);
        color: white;
    }
    
    .btn-cancel {
        background: white;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-title::before {
        content: '';
        display: block;
        width: 4px;
        height: 16px;
        background: var(--primary-light);
        border-radius: 4px;
    }
</style>

<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="page-title">Submit Study Progress Report</h1>
            <p class="page-subtitle">Report your study progress periodically for program monitoring.</p>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                        <h6 class="mb-0 fw-bold">Please correct the following errors:</h6>
                    </div>
                <div class="alert alert-danger mb-4 shadow-sm">
                    <strong>Terdapat beberapa kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('study-progress-report.store') }}" method="POST" enctype="multipart/form-data" id="studyProgressForm">
                @csrf

                <!-- 1. DATA KARYAWAN & STUDY (READONLY) -->
                <div class="glass-card">
                    <div class="card-header-modern">
                        <div class="card-header-icon"><i class="bi bi-person-badge"></i></div>
                        <h5>Employee & Study Profile</h5>
                    </div>
                <div class="card-body-modern">
                    @php $user = auth()->user(); @endphp
                    <div class="info-grid mb-4">
                        <div class="info-item">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div class="info-item bg-white border-primary shadow-sm" style="border-color: rgba(37,99,235,0.2) !important;">
                            <div class="info-label text-primary">NIK</div>
                            <input type="text" name="nik" class="form-control form-control-sm border-0 p-0 fw-bold" value="{{ old('nik', $user->nik) }}" placeholder="Enter NIK (Editable)">
                        </div>
                        <div class="info-item bg-white border-primary shadow-sm" style="border-color: rgba(37,99,235,0.2) !important;">
                            <div class="info-label text-primary">Company</div>
                            <input type="text" name="company" class="form-control form-control-sm border-0 p-0 fw-bold" value="{{ old('company', $user->company) }}" placeholder="Enter Company (Editable)">
                        </div>
                        <div class="info-item bg-white border-primary shadow-sm" style="border-color: rgba(37,99,235,0.2) !important;">
                            <div class="info-label text-primary">Position</div>
                            <input type="text" name="position" class="form-control form-control-sm border-0 p-0 fw-bold" value="{{ old('position', $user->position) }}" placeholder="Enter Position (Editable)">
                        </div>
                        <div class="info-item bg-white border-primary shadow-sm" style="border-color: rgba(37,99,235,0.2) !important;">
                            <div class="info-label text-primary">Department</div>
                            <select name="department_id" class="form-select form-select-sm border-0 p-0 fw-bold shadow-none select2">
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="info-item bg-white border-primary shadow-sm" style="border-color: rgba(37,99,235,0.2) !important;">
                            <div class="info-label text-primary">Group Head</div>
                            <select name="group_id" class="form-select form-select-sm border-0 p-0 fw-bold shadow-none select2">
                                <option value="">-- Select Group --</option>
                                @foreach($groups as $grp)
                                    <option value="{{ $grp->id }}" {{ old('group_id', $user->group_id) == $grp->id ? 'selected' : '' }}>{{ $grp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="info-item bg-white border-primary shadow-sm" style="border-color: rgba(37,99,235,0.2) !important;">
                            <div class="info-label text-primary">Direktorat</div>
                            <select name="direktorat_id" class="form-select form-select-sm border-0 p-0 fw-bold shadow-none select2">
                                <option value="">-- Select Direktorat --</option>
                                @foreach($direktorats as $dir)
                                    <option value="{{ $dir->id }}" {{ old('direktorat_id', $user->direktorat_id) == $dir->id ? 'selected' : '' }}>{{ $dir->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h6 class="section-title mt-4">PSP Application Data</h6>
                    @if($pspApplication)
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">University & Country</div>
                                <div class="info-value">{{ $pspApplication->studyPlan->programStudy->university ?? '-' }} · {{ $pspApplication->studyPlan->programStudy->country ?? '-' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Program Study</div>
                                <div class="info-value">{{ $pspApplication->studyPlan->programStudy->name ?? '-' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Degree</div>
                                <div class="info-value">
                                    <span class="badge bg-danger rounded-pill px-3">{{ strtoupper($pspApplication->studyPlan->programStudy->degree ?? '-') }}</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Approved By (Dir)</div>
                                <div class="info-value">{{ $pspApplication->direktoratApprover->name ?? '-' }}</div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning border-0 rounded-3 mb-0">
                            <i class="bi bi-info-circle me-2"></i> You do not have an approved PSP Application. Some data might be missing.
                        </div>
                    @endif
                </div>
            </div>

            <!-- 2. BASIC INFORMATION -->
                <div class="glass-card">
                    <div class="card-header-modern">
                        <div class="card-header-icon"><i class="bi bi-info-circle"></i></div>
                        <h5>Academic Progress</h5>
                    </div>
                    <div class="card-body-modern">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-123 text-muted"></i></span>
                                    <input type="number" name="semester" id="semester" class="form-control border-start-0 ps-0" required min="1" value="{{ old('semester') }}" placeholder="e.g. 3">
                                </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Semester</label>
                                <input type="number" name="semester" class="form-control" value="{{ old('semester') }}" min="1" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">IPK (Semester Ini)</label>
                                <input type="number" name="gpa" class="form-control" step="0.01" min="0" max="4" value="{{ old('gpa') }}">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Max IPK / GPA Scale</label>
                                <input type="number" name="max_gpa" class="form-control" step="0.01" min="0" max="4" value="{{ old('max_gpa', 4.00) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. COURSE PROGRESS -->
                <div class="glass-card">
                    <div class="card-header-modern">
                        <div class="card-header-icon"><i class="bi bi-journal-bookmark"></i></div>
                        <h5>Course Progress</h5>
                    </div>
                    <div class="card-body-modern">
                        
                        <h6 class="section-title">Completed Courses (Mata Kuliah yang Telah Ditempuh)</h6>
                        <table class="modern-table" id="completedCoursesTable">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th width="150">Credits (SKS)</th>
                                    <th width="150">Grade (Nilai)</th>
                                    <th width="60" class="text-center"><i class="bi bi-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="completed_courses_name[]" class="form-control" placeholder="e.g. Data Structure"></td>
                                    <td><input type="number" name="completed_courses_credits[]" class="form-control" min="1" placeholder="3"></td>
                                    <td><input type="text" name="completed_courses_grade[]" class="form-control" placeholder="A"></td>
                                    <td class="text-center"><button type="button" class="btn-delete-row" onclick="removeRow(this)"><i class="bi bi-trash3"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="javascript:void(0)" class="btn-add-row mb-4" onclick="addCompletedCourseRow()">
                            <i class="bi bi-plus-circle me-1"></i> Add Completed Course
                        </a>

                        <h6 class="section-title">Ongoing Courses (Mata Kuliah Sedang Ditempuh)</h6>
                        <table class="modern-table" id="ongoingCoursesTable">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th width="150">Credits (SKS)</th>
                                    <th width="60" class="text-center"><i class="bi bi-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="ongoing_courses_name[]" class="form-control" placeholder="e.g. Artificial Intelligence"></td>
                                    <td><input type="number" name="ongoing_courses_credits[]" class="form-control" min="1" placeholder="3"></td>
                                    <td class="text-center"><button type="button" class="btn-delete-row" onclick="removeRow(this)"><i class="bi bi-trash3"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="javascript:void(0)" class="btn-add-row mb-4" onclick="addOngoingCourseRow()">
                            <i class="bi bi-plus-circle me-1"></i> Add Ongoing Course
                        </a>

                        <h6 class="section-title">Upcoming Courses (Mata Kuliah Akan Ditempuh)</h6>
                        <table class="modern-table" id="upcomingCoursesTable">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th width="150">Credits (SKS)</th>
                                    <th width="60" class="text-center"><i class="bi bi-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="upcoming_courses_name[]" class="form-control" placeholder="e.g. Machine Learning"></td>
                                    <td><input type="number" name="upcoming_courses_credits[]" class="form-control" min="1" placeholder="3"></td>
                                    <td class="text-center"><button type="button" class="btn-delete-row" onclick="removeRow(this)"><i class="bi bi-trash3"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="javascript:void(0)" class="btn-add-row" onclick="addUpcomingCourseRow()">
                            <i class="bi bi-plus-circle me-1"></i> Add Upcoming Course
                        </a>
                    </div>
                </div>

                <!-- 4. THESIS & RESEARCH DATA -->
                <div class="glass-card">
                    <div class="card-header-modern">
                        <div class="card-header-icon"><i class="bi bi-mortarboard"></i></div>
                        <h5>Thesis & Research Data</h5>
                    </div>
                    <div class="card-body-modern">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Thesis Title</label>
                                <input type="text" name="thesis_title" class="form-control" value="{{ old('thesis_title') }}" placeholder="Enter your thesis title">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Title Status</label>
                                <select name="thesis_title_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="approved">Approved</option>
                                </select>
                            </div>
                            
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Thesis Proposal</label>
                                <input type="text" name="thesis_proposal" class="form-control" value="{{ old('thesis_proposal') }}" placeholder="Enter your thesis proposal details">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Proposal Status</label>
                                <select name="thesis_proposal_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="approved">Approved</option>
                                </select>
                            </div>
                        </div>

                        <h6 class="section-title mt-2">Thesis Milestones</h6>
                        <div class="row bg-light p-3 rounded-3 mx-0 mb-4 border" style="border-color: #f1f5f9 !important;">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Proposal Exam Status</label>
                                <select name="proposal_exam_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="finish">Finish</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Proposal Exam Date</label>
                                <input type="date" name="proposal_exam_date" class="form-control" value="{{ old('proposal_exam_date') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Proposal Exam Score</label>
                                <input type="text" name="proposal_exam_score" class="form-control" value="{{ old('proposal_exam_score') }}" placeholder="e.g. 85 or A">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Proposal Revision</label>
                                <select name="proposal_revision_status" class="form-select">
                                    <option value="">-- Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="approved">Approved</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Research Impl.</label>
                                <select name="research_implementation_status" class="form-select">
                                    <option value="">-- Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="finish">Finish</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Data Collection</label>
                                <select name="data_collection_status" class="form-select">
                                    <option value="">-- Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="finish">Finish</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Data Analysis</label>
                                <select name="data_analysis_status" class="form-select">
                                    <option value="">-- Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="finish">Finish</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Thesis Writing</label>
                                <select name="thesis_writing_status" class="form-select">
                                    <option value="">-- Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="finish">Finish</option>
                                </select>
                            </div>
                        </div>

                        <h6 class="section-title mt-2">Final Thesis Exam</h6>
                        <div class="row bg-light p-3 rounded-3 mx-0 border mb-4" style="border-color: #f1f5f9 !important;">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Thesis Exam Status</label>
                                <select name="thesis_exam_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="finish">Finish</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Thesis Exam Date</label>
                                <input type="date" name="thesis_exam_date" class="form-control" value="{{ old('thesis_exam_date') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Thesis Exam Score</label>
                                <input type="text" name="thesis_exam_score" class="form-control" value="{{ old('thesis_exam_score') }}" placeholder="e.g. 90 or A">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Thesis Revision Status</label>
                                <select name="thesis_revision_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="approved">Approved</option>
                                </select>
                            </div>
                        </div>

                        <h6 class="section-title mt-2">Journal Publication</h6>
                        <div class="row bg-light p-3 rounded-3 mx-0 border" style="border-color: #f1f5f9 !important;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Journal Article Status</label>
                                <select name="journal_article_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="finish">Finish</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Journal Publication Status</label>
                                <select name="journal_publication_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="on_process">On Process</option>
                                    <option value="finish">Finish</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. OTHER ACTIVITIES -->
                <div class="glass-card">
                    <div class="card-header-modern">
                        <div class="card-header-icon"><i class="bi bi-trophy"></i></div>
                        <h5>Other Academic Activities</h5>
                    </div>
                    <div class="card-body-modern">
                        <table class="modern-table" id="activitiesTable">
                            <thead>
                                <tr>
                                    <th>Activity Name</th>
                                    <th width="200">Date</th>
                                    <th>Description / Role</th>
                                    <th width="60" class="text-center"><i class="bi bi-gear"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="activity_name[]" class="form-control" placeholder="e.g. International Seminar"></td>
                                    <td><input type="date" name="activity_date[]" class="form-control"></td>
                                    <td><input type="text" name="activity_description[]" class="form-control" placeholder="e.g. Speaker"></td>
                                    <td class="text-center"><button type="button" class="btn-delete-row" onclick="removeRow(this)"><i class="bi bi-trash3"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="javascript:void(0)" class="btn-add-row" onclick="addActivityRow()">
                            <i class="bi bi-plus-circle me-1"></i> Add Activity
                        </a>
                    </div>
                </div>

                <!-- Certificates & Signature -->
                <div class="card glass-card mb-4 border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="section-title">
                            <i class="bi bi-file-earmark-medical-fill me-2 text-primary"></i> 
                            Certificates & Signature
                        </div>

                        <div class="mb-4">
                            <label for="certificates" class="form-label">Upload Certificates <span class="text-muted">(Optional)</span></label>
                            <input class="form-control" type="file" id="certificates" name="certificates[]" accept=".pdf,image/*" multiple>
                            <div class="form-text">You can select multiple files. PDF or Image max 5MB.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Participant Signature</label>
                            <div class="form-text mb-3">You can either draw your signature below or upload an image.</div>
                            
                            <ul class="nav nav-pills mb-3" id="signature-pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active rounded-pill px-4 me-2" id="pills-draw-tab" data-bs-toggle="pill" data-bs-target="#pills-draw" type="button" role="tab" style="font-size: 0.9rem;">Draw Signature</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill px-4" id="pills-upload-tab" data-bs-toggle="pill" data-bs-target="#pills-upload" type="button" role="tab" style="font-size: 0.9rem;">Upload Image</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-draw" role="tabpanel">
                                    <div class="border rounded-3" style="background: #f8fafc; overflow: hidden; width: fit-content;">
                                        <canvas id="signature-pad" class="signature-pad" width="400" height="200"></canvas>
                                    </div>
                                    <input type="hidden" name="signature_pad" id="signature_pad_input">
                                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clear-signature">
                                        <i class="bi bi-eraser me-1"></i> Clear
                                    </button>
                                </div>
                                <div class="tab-pane fade" id="pills-upload" role="tabpanel">
                                    <input class="form-control" type="file" name="signature_image" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mb-5 mt-4">
                    <a href="{{ route('dashboard') }}" class="btn-cancel text-decoration-none">Cancel</a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-send-check me-2"></i> Submit Report
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function removeRow(btn) {
        let tbody = btn.closest('tbody');
        if (tbody.querySelectorAll('tr').length > 1) {
            btn.closest('tr').remove();
        } else {
            // clear inputs if it's the last row
            let inputs = btn.closest('tr').querySelectorAll('input');
            inputs.forEach(input => input.value = '');
        }
    }

    function addCompletedCourseRow() {
        let tbody = document.querySelector('#completedCoursesTable tbody');
        let html = `
            <tr>
                <td><input type="text" name="completed_courses_name[]" class="form-control" placeholder="e.g. Data Structure"></td>
                <td><input type="number" name="completed_courses_credits[]" class="form-control" min="1" placeholder="3"></td>
                <td><input type="text" name="completed_courses_grade[]" class="form-control" placeholder="A"></td>
                <td class="text-center"><button type="button" class="btn-delete-row" onclick="removeRow(this)"><i class="bi bi-trash3"></i></button></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', html);
    }

    function addOngoingCourseRow() {
        let tbody = document.querySelector('#ongoingCoursesTable tbody');
        let html = `
            <tr>
                <td><input type="text" name="ongoing_courses_name[]" class="form-control" placeholder="e.g. Artificial Intelligence"></td>
                <td><input type="number" name="ongoing_courses_credits[]" class="form-control" min="1" placeholder="3"></td>
                <td class="text-center"><button type="button" class="btn-delete-row" onclick="removeRow(this)"><i class="bi bi-trash3"></i></button></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', html);
    }

    function addUpcomingCourseRow() {
        let tbody = document.querySelector('#upcomingCoursesTable tbody');
        let html = `
            <tr>
                <td><input type="text" name="upcoming_courses_name[]" class="form-control" placeholder="e.g. Machine Learning"></td>
                <td><input type="number" name="upcoming_courses_credits[]" class="form-control" min="1" placeholder="3"></td>
                <td class="text-center"><button type="button" class="btn-delete-row" onclick="removeRow(this)"><i class="bi bi-trash3"></i></button></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', html);
    }

    function addActivityRow() {
        let tbody = document.querySelector('#activitiesTable tbody');
        let html = `
            <tr>
                <td><input type="text" name="activity_name[]" class="form-control" placeholder="e.g. International Seminar"></td>
                <td><input type="date" name="activity_date[]" class="form-control"></td>
                <td><input type="text" name="activity_description[]" class="form-control" placeholder="e.g. Speaker"></td>
                <td class="text-center"><button type="button" class="btn-delete-row" onclick="removeRow(this)"><i class="bi bi-trash3"></i></button></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', html);
    }
</script>

<!-- jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        // Signature Pad initialization
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'
        });

        document.getElementById('clear-signature').addEventListener('click', function () {
            signaturePad.clear();
            document.getElementById('signature_pad_input').value = '';
        });

        // Before submit, get data URL
        $('form').on('submit', function() {
            if (!signaturePad.isEmpty()) {
                document.getElementById('signature_pad_input').value = signaturePad.toDataURL();
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
@endsection
