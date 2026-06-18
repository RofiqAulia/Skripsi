@if($lockedMentorId)
<section class="section-schedule" id="schedule-section">
<div class="container-lg">

    <div class="schedule-header">
        <div>
            <h2><i class="bi bi-calendar2-check"></i> Book Your Session</h2>
            <p>Choose your preferred time slot from the available schedule below.</p>
        </div>
        <a href="{{ route('mentoring.history') }}" class="btn-history">
            <i class="bi bi-clock-history"></i> Session History
        </a>
    </div>

    @if($schedules->isEmpty())
        <div class="schedule-empty">
            <div class="empty-icon"><i class="bi bi-calendar-x"></i></div>
            <h4>No Schedule Available</h4>
            <p>Your mentor hasn't set any available time slots yet. Please check back later.</p>
        </div>
    @else

    @foreach ($schedules as $mentorId => $items)

    @php
        $mentor = $items->first()->mentor;
        $groupedDates = $items->groupBy('date');
    @endphp

    <!-- MENTOR INFO CARD -->
    <div class="schedule-mentor-card">
        <div class="smc-left">
            @if($mentor->photo)
                <img src="{{ asset('storage/' . $mentor->photo) }}" class="smc-avatar" alt="{{ $mentor->user->name }}">
            @else
                <div class="smc-avatar-placeholder">{{ strtoupper(substr($mentor->user->name, 0, 1)) }}</div>
            @endif
            <div>
                <h5>{{ $mentor->user->name }}</h5>
                <span>{{ $mentor->current_position }} · {{ $mentor->company }}</span>
            </div>
        </div>
        <div class="smc-right">
            <span class="smc-badge"><i class="bi bi-calendar3"></i> {{ $groupedDates->count() }} days available</span>
        </div>
    </div>

    <!-- CALENDAR GRID -->
    <div class="schedule-grid">

        @foreach ($groupedDates as $date => $slots)

        <div class="schedule-day-card">

            <div class="sdc-date">
                <span class="sdc-day-num">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                <span class="sdc-day-name">{{ \Carbon\Carbon::parse($date)->format('D') }}</span>
                <span class="sdc-month">{{ \Carbon\Carbon::parse($date)->format('M Y') }}</span>
            </div>

            <div class="sdc-slots">
                @foreach ($slots as $schedule)
                    @php
                        $isBooked = $schedule->session !== null;
                    @endphp
                    <button
                        class="slot-chip {{ $isBooked ? 'booked' : '' }}"
                        data-id="{{ $schedule->id }}"
                        {{ $isBooked ? 'disabled' : '' }}>
                        <i class="bi {{ $isBooked ? 'bi-lock' : 'bi-clock' }}"></i>
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                        @if($schedule->end_time)
                            - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                        @endif
                    </button>
                @endforeach
            </div>

        </div>

        @endforeach

    </div>

    @endforeach

    <!-- BOOKING FORM -->
    <div class="booking-panel" id="bookingPanel">
        <form action="{{ route('mentoring.book-schedule') }}" method="POST" id="bookForm">
            @csrf
            <input type="hidden" name="schedule_id" id="scheduleInput">

            <div class="bp-inner">
                <div class="bp-selected">
                    <i class="bi bi-check-circle-fill"></i>
                    <span id="selectedSlotText">Select a time slot above</span>
                </div>

                <div class="bp-link">
                    <label for="link_meet"><i class="bi bi-camera-video"></i> Meeting Link <span class="text-danger">*</span></label>
                    <input type="url" name="link_meet" id="link_meet" class="bp-input" placeholder="https://zoom.us/j/... or https://meet.google.com/..." required>
                </div>

                <button type="submit" class="btn-book" id="btnBook" disabled>
                    <i class="bi bi-send"></i> Confirm & Send Notification
                </button>
            </div>
        </form>
    </div>

    @endif

</div>
</section>
@endif

<style>
/* ═══ HEADER ═══ */
.schedule-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 32px;
    padding-top: 40px;
}

.schedule-header h2 {
    font-size: 28px;
    font-weight: 700;
    color: #111;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.schedule-header h2 i { color: #8b0000; }

.schedule-header p {
    font-size: 15px;
    color: #6b7280;
    margin: 4px 0 0;
}

.btn-history {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    transition: .2s;
}

.btn-history:hover {
    border-color: #8b0000;
    color: #8b0000;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(139,0,0,.1);
}

/* ═══ EMPTY STATE ═══ */
.schedule-empty {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
}

.empty-icon {
    font-size: 48px;
    color: #d1d5db;
    margin-bottom: 16px;
}

.schedule-empty h4 { color: #374151; font-size: 18px; }
.schedule-empty p { color: #9ca3af; font-size: 14px; }

/* ═══ MENTOR CARD ═══ */
.schedule-mentor-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: linear-gradient(135deg, #fff5f5, #fff);
    border: 1px solid rgba(139,0,0,.08);
    border-radius: 14px;
    margin-bottom: 24px;
}

.smc-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.smc-avatar {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.smc-avatar-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
}

.smc-left h5 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #111;
}

.smc-left span {
    font-size: 13px;
    color: #6b7280;
}

.smc-badge {
    font-size: 12px;
    font-weight: 500;
    color: #16a34a;
    background: rgba(34,197,94,.08);
    padding: 6px 14px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* ═══ SCHEDULE GRID ═══ */
.schedule-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}

.schedule-day-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    padding: 18px;
    transition: .2s;
}

.schedule-day-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,.06);
    border-color: rgba(139,0,0,.1);
}

.sdc-date {
    text-align: center;
    padding-bottom: 12px;
    margin-bottom: 12px;
    border-bottom: 1px solid #f3f4f6;
}

.sdc-day-num {
    display: block;
    font-size: 28px;
    font-weight: 700;
    color: #8b0000;
    line-height: 1;
}

.sdc-day-name {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-top: 2px;
}

.sdc-month {
    display: block;
    font-size: 11px;
    color: #9ca3af;
    margin-top: 2px;
}

/* ═══ SLOTS ═══ */
.sdc-slots {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.slot-chip {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 13px;
    font-weight: 500;
    background: #fafafa;
    cursor: pointer;
    transition: .2s;
    display: flex;
    align-items: center;
    gap: 6px;
    color: #374151;
}

.slot-chip:hover:not(.booked) {
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
    border-color: transparent;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139,0,0,.25);
}

.slot-chip.active {
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 16px rgba(139,0,0,.3);
}

.slot-chip.booked {
    opacity: 0.4;
    cursor: not-allowed;
    text-decoration: line-through;
}

/* ═══ BOOKING PANEL ═══ */
.booking-panel {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,.04);
    margin-bottom: 50px;
}

.bp-inner {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.bp-selected {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: #f9fafb;
    border-radius: 10px;
    font-size: 14px;
    color: #6b7280;
}

.bp-selected i {
    font-size: 18px;
    color: #d1d5db;
}

.bp-selected.has-selection {
    background: #dcfce7;
    color: #16a34a;
}

.bp-selected.has-selection i {
    color: #16a34a;
}

.bp-link label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 8px;
}

.bp-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: .2s;
    outline: none;
}

.bp-input:focus {
    border-color: #8b0000;
    box-shadow: 0 0 0 3px rgba(139,0,0,.08);
}

.btn-book {
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: #fff;
    border: none;
    padding: 14px 32px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: .3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    align-self: flex-start;
    box-shadow: 0 6px 20px rgba(139,0,0,.3);
}

.btn-book:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(139,0,0,.4);
}

.btn-book:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 768px) {
    .schedule-header { flex-direction: column; }
    .schedule-grid { grid-template-columns: 1fr; }
    .schedule-mentor-card { flex-direction: column; gap: 12px; align-items: flex-start; }
}
</style>

<script>
let selectedSlotId = null;

document.querySelectorAll(".slot-chip").forEach(btn => {
    btn.addEventListener("click", function () {
        if (this.classList.contains("booked")) return;

        // Remove active from all
        document.querySelectorAll(".slot-chip").forEach(b => b.classList.remove("active"));

        // Activate this
        this.classList.add("active");

        selectedSlotId = this.dataset.id;
        document.getElementById("scheduleInput").value = selectedSlotId;
        document.getElementById("btnBook").disabled = false;

        // Update selected text
        const selectedEl = document.querySelector(".bp-selected");
        selectedEl.classList.add("has-selection");
        document.getElementById("selectedSlotText").textContent = "Time slot selected: " + this.textContent.trim();
    });
});
</script>
