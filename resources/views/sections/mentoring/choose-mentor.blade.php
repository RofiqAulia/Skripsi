<section class="section-mentor py-5">

<div class="container-lg">

    <!-- TITLE -->
    <div class="mentor-header text-center mb-5">
        <h2>Choose Your Mentor</h2>
        <p>
            Select a mentor who aligns with your study goals and professional background.
        </p>
    </div>

    <!-- MENTOR LIST (scrollable, max 5 visible) -->
    <div class="mentor-list-container">
        <div class="mentor-list">

        @foreach ($mentors as $mentor)

        @php
            $user = $mentor->user;

            $education = $mentor->education ?? [];
            $career = $mentor->career_journey ?? [];
            $achievement = $mentor->achievements ?? [];

            $filled = $mentor->unique_mentees_count ?? 0;
            $quota = $mentor->quota ?? 0;
            $isFull = $filled >= $quota;
            
            $hasChosen = isset($lockedMentorId);
            $isMyMentor = $hasChosen && $lockedMentorId == $mentor->id;
            
            $isDisabled = $isFull || $hasChosen;
            
            if ($isMyMentor) {
                $statusText = 'Selected';
            } elseif ($hasChosen) {
                $statusText = 'Locked';
            } elseif ($isFull) {
                $statusText = 'Unavailable';
            } else {
                $statusText = 'Select';
            }
        @endphp

        <div class="mentor-card {{ $isDisabled ? 'disabled' : '' }} {{ (isset($lockedMentorId) && $lockedMentorId == $mentor->id) ? 'active' : '' }}">

            <div class="mentor-main">
                @php
                    $photoUrl = $mentor->photo ? asset('storage/' . $mentor->photo) : asset('images/mentorship.webp');
                @endphp
                <img src="{{ $photoUrl }}" class="mentor-img" alt="{{ $user->name ?? 'Mentor' }}">

                <div class="mentor-info">
                    <h5>{{ $user->name ?? '-' }}</h5>

                    <div class="mentor-meta">
                        <span><i class="bi bi-briefcase"></i> {{ $mentor->current_position ?? '-' }}</span>
                        <span><i class="bi bi-building"></i> {{ $mentor->company ?? '-' }}</span>
                    </div>

                    <div class="mentor-detail">
                        <span>🎓 {{ $education[0] ?? '-' }}</span>
                        <span>🌍 {{ count($career) }} Career Steps</span>
                    </div>
                </div>
            </div>

            <div class="mentor-side">

                <div class="mentor-status">
                    <span class="status {{ $isFull ? 'danger' : 'success' }}">
                        {{ $isFull ? 'Closed' : 'Available' }}
                    </span>
                    <small>{{ $filled }} / {{ $quota }} Mentees</small>
                </div>

                <div class="mentor-actions">
                    <button class="btn-select secondary btn-detail" type="button"
                        data-name="{{ $user->name ?? '-' }}"
                        data-role="{{ $mentor->current_position ?? '-' }}"
                        data-company="{{ $mentor->company ?? '-' }}"
                        data-img="{{ $photoUrl }}"
                        data-education='@json($education)'
                        data-career='@json($career)'
                        data-achievement='@json($achievement)'
                    >
                        <i class="bi bi-list-ul"></i></i> Detail
                    </button>

                    <form action="{{ route('mentoring.select-mentor') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="mentor_id" value="{{ $mentor->id }}">
                        <button type="submit" class="btn-select {{ $isDisabled ? 'disabled' : 'primary' }}" {{ $isDisabled ? 'disabled' : '' }}>
                            <i class="bi bi-check2-circle"></i> {{ $statusText }}
                        </button>
                    </form>
                </div>

            </div>

        </div>

        @endforeach

        </div>

        @if($mentors->count() > 5)
            <div class="scroll-hint">
                <i class="bi bi-mouse"></i> Scroll to see more mentors
            </div>
        @endif
    </div>

</div>


<!-- ================= MODAL ================= -->
<div id="mentorModal" class="mentor-modal">

    <div class="modal-box">

        <span class="modal-close">&times;</span>

        <!-- HEADER -->
        <div class="modal-header">

            <img id="modalImg" class="modal-img">

            <div>
                <h3 id="modalName"></h3>
                <p class="modal-role" id="modalRole"></p>
                <p class="modal-company" id="modalCompany"></p>
            </div>

        </div>

        <!-- EDUCATION -->
        <div class="modal-section">
            <h5>Education</h5>
            <ul id="modalEdu"></ul>
        </div>

        <!-- CAREER -->
        <div class="modal-section">
            <h5>Career Journey</h5>
            <ul id="modalCareer"></ul>
        </div>

        <!-- ACHIEVEMENT -->
        <div class="modal-section">
            <h5>Achievements</h5>
            <ul id="modalAchievement"></ul>
        </div>

    </div>

</div>

<style>
/* ================= HEADER ================= */
.mentor-header h2 {
    font-size: 34px;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.mentor-header p {
    color: #6b7280;
    max-width: 520px;
    margin: auto;
    font-size: 15px;
}

/* ================= SCROLLABLE CONTAINER ================= */
.mentor-list-container {
    position: relative;
}

.mentor-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    max-height: 620px;
    overflow-y: auto;
    padding-right: 8px;
    scroll-behavior: smooth;
}

/* Custom scrollbar */
.mentor-list::-webkit-scrollbar { width: 6px; }
.mentor-list::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
.mentor-list::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #8b0000, #c40000); border-radius: 10px; }
.mentor-list::-webkit-scrollbar-thumb:hover { background: #a00000; }

.scroll-hint {
    text-align: center;
    padding: 12px 0 0;
    font-size: 13px;
    color: #9ca3af;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    animation: bounceHint 2s infinite;
}

@keyframes bounceHint {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(4px); }
}

/* ================= CARD ================= */
.mentor-card {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-radius: 16px;
    background: #fff;
    border: 1px solid #eee;
    transition: all 0.3s ease;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
}

.mentor-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    border-color: rgba(139,0,0,.15);
}

/* ACCENT LINE */
.mentor-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 20%;
    height: 60%;
    width: 4px;
    background: linear-gradient(180deg, #8b0000, #c40000);
    border-radius: 4px;
    opacity: 0;
    transition: 0.3s;
}

.mentor-card:hover::before { opacity: 1; }

/* ACTIVE (selected mentor) */
.mentor-card.active {
    border: 2px solid #8b0000;
    background: linear-gradient(145deg, #fff, #fff5f5);
    box-shadow: 0 8px 30px rgba(139,0,0,0.12);
}

.mentor-card.active::before { opacity: 1; }

/* DISABLED */
.mentor-card.disabled {
    opacity: 0.45;
    filter: grayscale(0.3);
}

.mentor-card.disabled:hover {
    transform: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
}

/* ================= LEFT ================= */
.mentor-main {
    display: flex;
    gap: 16px;
    align-items: center;
    flex: 1;
    min-width: 0;
}

.mentor-img {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    object-fit: cover;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    flex-shrink: 0;
}

.mentor-info { min-width: 0; }

.mentor-info h5 {
    margin: 0;
    font-weight: 600;
    font-size: 15px;
    color: #111;
}

.mentor-meta {
    font-size: 13px;
    color: #6b7280;
    display: flex;
    gap: 12px;
    margin-top: 4px;
}

.mentor-meta i { font-size: 12px; margin-right: 3px; }

.mentor-detail {
    margin-top: 6px;
    font-size: 12px;
    color: #9ca3af;
    display: flex;
    gap: 12px;
}

/* ================= RIGHT ================= */
.mentor-side {
    text-align: right;
    flex-shrink: 0;
}

.mentor-status {
    margin-bottom: 10px;
}

.status {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 999px;
    display: inline-block;
}

.mentor-status small {
    display: block;
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
}

.status.success {
    background: rgba(34,197,94,0.1);
    color: #16a34a;
}

.status.danger {
    background: rgba(239,68,68,0.1);
    color: #dc2626;
}

/* BUTTONS */
.mentor-actions {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

.btn-select {
    border: 1px solid #e5e7eb;
    padding: 7px 16px;
    border-radius: 999px;
    background: #fff;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.25s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-select:hover {
    border-color: #8b0000;
    color: #8b0000;
    transform: translateY(-1px);
}

.btn-select.primary {
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
    border: none;
    box-shadow: 0 4px 14px rgba(139,0,0,0.25);
}

.btn-select.primary:hover {
    background: linear-gradient(135deg, #a00000, #d40000);
    box-shadow: 0 6px 20px rgba(139,0,0,0.35);
}

.btn-select.disabled {
    border-color: #eee;
    color: #bbb;
    cursor: not-allowed;
    box-shadow: none;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .mentor-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .mentor-side {
        text-align: left;
        width: 100%;
    }

    .mentor-actions {
        justify-content: flex-start;
    }

    .mentor-list {
        max-height: none;
    }
}

/* ================= MODAL ================= */
.mentor-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.mentor-modal.show { display: flex; }

.modal-box {
    background: #fff;
    width: 520px;
    max-height: 85vh;
    overflow-y: auto;
    padding: 30px;
    border-radius: 22px;
    position: relative;
    box-shadow: 0 30px 80px rgba(0,0,0,0.25);
    animation: fadeUp 0.3s ease;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.modal-close {
    position: absolute;
    top: 15px;
    right: 20px;
    cursor: pointer;
    font-size: 22px;
    opacity: 0.6;
}

.modal-close:hover { opacity: 1; }

.modal-header {
    display: flex;
    gap: 16px;
    align-items: center;
    margin-bottom: 20px;
}

.modal-img {
    width: 75px;
    height: 75px;
    border-radius: 18px;
    object-fit: cover;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.modal-header h3 { margin: 0; font-size: 18px; }
.modal-role { font-weight: 600; }
.modal-company { color: #6b7280; font-size: 13px; }

.modal-section {
    margin-top: 22px;
    padding-top: 12px;
    border-top: 1px solid #f1f1f1;
}

.modal-section h5 {
    font-size: 13px;
    margin-bottom: 8px;
    color: #8b0000;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.modal-section ul { padding-left: 18px; margin: 0; }
.modal-section li { font-size: 13px; margin-bottom: 6px; color: #444; }

</style>



<script>
const modal = document.getElementById("mentorModal");

function renderList(data) {
    try {
        const arr = JSON.parse(data);
        if (!Array.isArray(arr) || arr.length === 0) return "<li>-</li>";
        return arr.map(item => `<li>${item}</li>`).join("");
    } catch {
        return "<li>-</li>";
    }
}

document.querySelectorAll(".btn-detail").forEach(btn => {
    btn.addEventListener("click", function () {
        document.getElementById("modalName").innerText = this.dataset.name;
        document.getElementById("modalRole").innerText = this.dataset.role;
        document.getElementById("modalCompany").innerText = this.dataset.company;
        document.getElementById("modalImg").src = this.dataset.img;
        document.getElementById("modalEdu").innerHTML = renderList(this.dataset.education);
        document.getElementById("modalCareer").innerHTML = renderList(this.dataset.career);
        document.getElementById("modalAchievement").innerHTML = renderList(this.dataset.achievement);
        modal.classList.add("show");
    });
});

document.querySelector(".modal-close").onclick = () => modal.classList.remove("show");

window.onclick = (e) => {
    if (e.target === modal) modal.classList.remove("show");
};
</script>

</section>