@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="mb-4">Submit Study Progress Report</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('study-progress-report.store') }}" method="POST">
                @csrf

                <!-- Basic Information -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <input type="number" name="semester" id="semester" class="form-control" required min="1" value="{{ old('semester') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gpa" class="form-label">Current GPA (IPK) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="gpa" id="gpa" class="form-control" required min="0" max="4" value="{{ old('gpa') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="max_gpa" class="form-label">Max GPA (Skala) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="max_gpa" id="max_gpa" class="form-control" required min="0" max="4" value="{{ old('max_gpa', 4.00) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Progress -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Course Progress</h5>
                    </div>
                    <div class="card-body">
                        
                        <h6>Completed Courses (Mata Kuliah yang Telah Ditempuh)</h6>
                        <table class="table table-bordered mb-4" id="completedCoursesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Course Name</th>
                                    <th>Credits (SKS)</th>
                                    <th>Grade (Nilai)</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="completed_courses_name[]" class="form-control"></td>
                                    <td><input type="number" name="completed_courses_credits[]" class="form-control" min="1"></td>
                                    <td><input type="text" name="completed_courses_grade[]" class="form-control"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"><button type="button" class="btn btn-secondary btn-sm" onclick="addCompletedCourseRow()">+ Add Course</button></td>
                                </tr>
                            </tfoot>
                        </table>

                        <h6>Ongoing Courses (Mata Kuliah Sedang Ditempuh)</h6>
                        <table class="table table-bordered mb-4" id="ongoingCoursesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Course Name</th>
                                    <th>Credits (SKS)</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="ongoing_courses_name[]" class="form-control"></td>
                                    <td><input type="number" name="ongoing_courses_credits[]" class="form-control" min="1"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><button type="button" class="btn btn-secondary btn-sm" onclick="addOngoingCourseRow()">+ Add Course</button></td>
                                </tr>
                            </tfoot>
                        </table>

                        <h6>Upcoming Courses (Mata Kuliah Akan Ditempuh)</h6>
                        <table class="table table-bordered mb-0" id="upcomingCoursesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Course Name</th>
                                    <th>Credits (SKS)</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="upcoming_courses_name[]" class="form-control"></td>
                                    <td><input type="number" name="upcoming_courses_credits[]" class="form-control" min="1"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><button type="button" class="btn btn-secondary btn-sm" onclick="addUpcomingCourseRow()">+ Add Course</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Thesis & Research Data -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Thesis & Research Data</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thesis Title</label>
                                <input type="text" name="thesis_title" class="form-control" value="{{ old('thesis_title') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thesis Title Status</label>
                                <select name="thesis_title_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="approved">Approved</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thesis Proposal</label>
                                <input type="text" name="thesis_proposal" class="form-control" value="{{ old('thesis_proposal') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thesis Proposal Status</label>
                                <select name="thesis_proposal_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="approved">Approved</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3">Thesis Milestones</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Proposal Exam Status</label>
                                <select name="proposal_exam_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Proposal Exam Date</label>
                                <input type="date" name="proposal_exam_date" class="form-control" value="{{ old('proposal_exam_date') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Proposal Exam Score</label>
                                <input type="text" name="proposal_exam_score" class="form-control" value="{{ old('proposal_exam_score') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Proposal Revision Status</label>
                                <select name="proposal_revision_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Research Implementation Status</label>
                                <select name="research_implementation_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data Collection Status</label>
                                <select name="data_collection_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data Analysis Status</label>
                                <select name="data_analysis_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thesis Writing Status</label>
                                <select name="thesis_writing_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-3">Final Exam & Publication</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Thesis Exam Status</label>
                                <select name="thesis_exam_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Thesis Exam Date</label>
                                <input type="date" name="thesis_exam_date" class="form-control" value="{{ old('thesis_exam_date') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Thesis Exam Score</label>
                                <input type="text" name="thesis_exam_score" class="form-control" value="{{ old('thesis_exam_score') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Thesis Revision Status</label>
                                <select name="thesis_revision_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Journal Article Status</label>
                                <select name="journal_article_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="accepted">Accepted</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Journal Publication Status</label>
                                <select name="journal_publication_status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_review">In Review</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Activities -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Other Academic Activities</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered mb-0" id="activitiesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Activity Name</th>
                                    <th width="200">Date</th>
                                    <th>Description</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="activity_name[]" class="form-control"></td>
                                    <td><input type="date" name="activity_date[]" class="form-control"></td>
                                    <td><input type="text" name="activity_description[]" class="form-control"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"><button type="button" class="btn btn-secondary btn-sm" onclick="addActivityRow()">+ Add Activity</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-5">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-danger px-4">Submit Report</button>
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
                <td><input type="text" name="completed_courses_name[]" class="form-control"></td>
                <td><input type="number" name="completed_courses_credits[]" class="form-control" min="1"></td>
                <td><input type="text" name="completed_courses_grade[]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', html);
    }

    function addOngoingCourseRow() {
        let tbody = document.querySelector('#ongoingCoursesTable tbody');
        let html = `
            <tr>
                <td><input type="text" name="ongoing_courses_name[]" class="form-control"></td>
                <td><input type="number" name="ongoing_courses_credits[]" class="form-control" min="1"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', html);
    }

    function addUpcomingCourseRow() {
        let tbody = document.querySelector('#upcomingCoursesTable tbody');
        let html = `
            <tr>
                <td><input type="text" name="upcoming_courses_name[]" class="form-control"></td>
                <td><input type="number" name="upcoming_courses_credits[]" class="form-control" min="1"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', html);
    }

    function addActivityRow() {
        let tbody = document.querySelector('#activitiesTable tbody');
        let html = `
            <tr>
                <td><input type="text" name="activity_name[]" class="form-control"></td>
                <td><input type="date" name="activity_date[]" class="form-control"></td>
                <td><input type="text" name="activity_description[]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', html);
    }
</script>
@endsection
