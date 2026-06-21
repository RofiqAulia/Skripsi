<section class="section-report py-5">

<div class="container-lg">

    <br><br><br>

    <!-- HEADER -->
    <div class="report-header text-center mb-5">
        <h2>Mentoring Report</h2>
        <p>Document your mentoring outcome and upload supporting files</p>
    </div>

<form method="POST" action="{{ route('report.store') }}" enctype="multipart/form-data">
@csrf

<!-- Mentor -->
<div class="mb-3">
    <label>Mentor</label>
    <input type="text" class="form-control" value="{{ $mentors->first()->user->name }}" readonly style="background-color: #f3f4f6; cursor: not-allowed;">
    <input type="hidden" name="mentor_id" id="mentorSelect" value="{{ $mentors->first()->id }}">
</div>

<!-- Schedule -->
<div class="mb-3">
    <label>Choose Schedule</label>
    <select name="schedule_id" id="scheduleSelect" class="form-control" required>
        <option value="">-- Select Schedule --</option>
    </select>
</div>

<!-- Meeting -->
<div class="mb-3">
    <label>Meeting Number</label>
    <input type="number" name="meeting_number" class="form-control" value="{{ $nextMeetingNumber ?? 1 }}" readonly style="background-color: #f3f4f6; cursor: not-allowed;">
</div>

<!-- Summary -->
<div class="mb-3">
    <label>Summary</label>
    <textarea name="summary" class="form-control" required></textarea>
</div>

<!-- Output -->
<div class="mb-3">
    <label>Output</label>
    <textarea name="output" class="form-control"></textarea>
</div>

<!-- File -->
<div class="mb-3">
    <label>Upload File</label>
    <input type="file" name="file" class="form-control">
</div>

<button class="btn btn-danger">Submit Report</button>

</form>

<!-- TOAST -->
<div id="toastReport" class="toast-success">
    ✅ Report submitted successfully!
</div>

<style>

/* HEADER */
.report-header h2 {
    font-size: 30px;
    font-weight: 700;
}

.report-header p {
    color: #6b7280;
}

/* WRAPPER */
.report-wrapper {
    max-width: 600px;
    margin: auto;
    background: #fff;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.05);
}

/* FORM */
.form-group {
    margin-bottom: 18px;
}

label {
    font-size: 14px;
    margin-bottom: 6px;
    display: block;
    font-weight: 500;
}

/* INPUT */
input, textarea {
    width: 100%;
    border-radius: 12px;
    border: 1px solid #ddd;
    padding: 12px;
    font-size: 14px;
    transition: 0.3s;
}

input:focus, textarea:focus {
    outline: none;
    border-color: #8b0000;
    box-shadow: 0 0 0 3px rgba(139,0,0,0.1);
}

/* FILE */
.file-upload {
    border: 1px dashed #ddd;
    padding: 15px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    cursor: pointer;
}

.file-upload:hover {
    border-color: #8b0000;
}

.file-upload input {
    display: none;
}

#fileName {
    font-size: 13px;
    color: #6b7280;
}

/* ERROR */
.error-text {
    color: #dc2626;
    font-size: 12px;
}

/* BUTTON */
.btn-submit {
    width: 100%;
    margin-top: 10px;
    background: #8b0000;
    color: #fff;
    border-radius: 999px;
    padding: 12px;
    border: none;
    cursor: pointer;
}

.btn-submit:hover {
    background: #a50000;
}

/* TOAST */
.toast-success {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #22c55e;
    color: #fff;
    padding: 14px 20px;
    border-radius: 12px;
    opacity: 0;
    transform: translateY(20px);
    transition: 0.3s;
}

.toast-success.show {
    opacity: 1;
    transform: translateY(0);
}


/* ================= BANNER ================= */
.report-banner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;

    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;

    padding: 30px;
    border-radius: 20px;
    margin-bottom: 40px;

    box-shadow: 0 20px 60px rgba(139,0,0,0.25);
}

/* TEXT */
.banner-text h3 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 8px;
}

.banner-text p {
    font-size: 14px;
    opacity: 0.9;
    max-width: 450px;
}

/* IMAGE */
.banner-image img {
    width: 160px;
    height: auto;
}

/* ================= SELECT ================= */
select {
    width: 100%;
    border-radius: 12px;
    border: 1px solid #ddd;
    padding: 12px;
    font-size: 14px;
    background: #fff;
}

select:focus {
    outline: none;
    border-color: #8b0000;
    box-shadow: 0 0 0 3px rgba(139,0,0,0.1);
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .report-banner {
        flex-direction: column;
        text-align: center;
    }

    .banner-image img {
        width: 120px;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const schedules = @json($schedules);
    const scheduleSelect = document.getElementById('scheduleSelect');

    // Karena schedules sudah difilter sesuai mentor yang aktif dari controller, kita bisa langsung meloopingnya
    schedules.forEach(s => {
        let option = document.createElement('option');
        option.value = s.id;
        option.text = s.date + ' | ' + s.start_time + ' - ' + s.end_time;
        scheduleSelect.appendChild(option);
    });

});
</script>

</section>