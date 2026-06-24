<section class="section-dashboard">
<div class="container-lg dash-container">

    <!-- ═══ HEADER ═══ -->
    <div class="dash-header">
        <div class="dash-header-title">
            <h1>Welcome back, {{ $user->name }}</h1>
            <p>Your Preparation Journey At a Glance</p>
        </div>
        <span class="dash-date"><i class="bi bi-calendar3"></i> {{ now()->format('l, d F Y') }}</span>
    </div>

    <!-- ═══ STAT CARDS ═══ -->
    <div class="stat-row">
        <!-- 2. PSP -->
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: var(--primary-grad);"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div class="stat-info">
                <span class="stat-label">PSP Status</span>
                <span class="stat-value" style="font-size: 22px;">
                    @if($pspApplication)
                        {{ ucfirst($pspApplication->status) }}
                    @else
                        Not Started
                    @endif
                </span>
                <span class="stat-sub">Personal Study Plan</span>
            </div>
        </div>

        <!-- 3. DOCUMENT -->
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: var(--primary-grad);"><i class="bi bi-folder2-open"></i></div>
            <div class="stat-info">
                <span class="stat-label">Documents</span>
                <span class="stat-value">{{ $docsUploaded }}/{{ $docsTotal }}</span>
                <span class="stat-sub">{{ $docsApproved }} Approved</span>
            </div>
        </div>

        <!-- 4. MENTORING -->
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: var(--primary-grad);"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
                <span class="stat-label">Mentoring</span>
                <span class="stat-value">{{ $sessionsDone }}/{{ $sessionsTotal }}</span>
                <span class="stat-sub">Sessions Completed</span>
            </div>
        </div>

        <!-- 4. SCHOLARSHIP -->
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: var(--primary-grad);"><i class="bi bi-trophy-fill"></i></div>
            <div class="stat-info">
                <span class="stat-label">Scholarship</span>
                <span class="stat-value">{{ $scholarshipLolos }}/{{ $scholarshipTotal }}</span>
                <span class="stat-sub">Applications Passed</span>
            </div>
        </div>

        <!-- 5. OVERALL PROGRESS -->
        <div class="stat-card glass-card stat-highlight">
            <div class="stat-icon" style="background: var(--primary-grad);"><i class="bi bi-bar-chart-line-fill"></i></div>
            <div class="stat-info">
                <span class="stat-label" style="color: rgba(255,255,255,0.9);">Overall Progress</span>
                <span class="stat-value">{{ $overallProgress }}%</span>
                <div class="progress-thin"><div style="width:{{ $overallProgress }}%"></div></div>
            </div>
        </div>
    </div>

    <!-- ═══ MAIN GRID ═══ -->
    <div class="dash-grid">

        <!-- ──── LEFT COLUMN ──── -->
        <div class="dash-left">

            <!-- DOCUMENT PROGRESS -->
            <div class="dash-card glass-card">
                <div class="card-head">
                    <h4><i class="bi bi-folder-check"></i> Document Progress</h4>
                    <a href="{{ route('document') }}" class="card-link">Upload →</a>
                </div>
                <div class="doc-list">
                    @foreach($requiredTypes as $type => $label)
                        @php $doc = $documents[$type] ?? null; @endphp
                        <div class="doc-item">
                            <div class="doc-status-icon
                                @if($doc && $doc->status === 'approved') st-approved
                                @elseif($doc && $doc->status === 'revisi') st-rejected
                                @elseif($doc) st-pending
                                @else st-empty @endif">
                                @if($doc && $doc->status === 'approved') <i class="bi bi-check-lg"></i>
                                @elseif($doc && $doc->status === 'revisi') <i class="bi bi-x-lg"></i>
                                @elseif($doc) <i class="bi bi-clock"></i>
                                @else <i class="bi bi-dash"></i> @endif
                            </div>
                            <div class="doc-info">
                                <span class="doc-name">{{ $label }}</span>
                                <small>
                                    @if($doc && $doc->status === 'approved') Approved
                                    @elseif($doc && $doc->status === 'revisi') Revisi @if($doc->notes) — {{ $doc->notes }} @endif
                                    @elseif($doc) Awaiting Review
                                    @else Not uploaded @endif
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- MY MENTOR -->
            <div class="dash-card glass-card">
                <div class="card-head">
                    <h4><i class="bi bi-person-workspace"></i> My Mentor</h4>
                    <a href="{{ route('mentoring') }}" class="card-link">Mentoring →</a>
                </div>
                @if($myMentor)
                    <div class="mentor-card">
                        <div class="mentor-avatar">
                            @if($myMentor->photo)
                                <img src="{{ asset($myMentor->photo) }}" alt="{{ $myMentor->user->name }}">
                            @else
                                <div class="avatar-placeholder"><i class="bi bi-person-fill"></i></div>
                            @endif
                        </div>
                        <div class="mentor-info">
                            <h5>{{ $myMentor->user->name }}</h5>
                            <p>{{ $myMentor->current_position }} · {{ $myMentor->company }}</p>
                        </div>
                    </div>
                @else
                    <div class="empty-hint">
                        <i class="bi bi-person-plus"></i>
                        <p>You haven't selected a mentor yet</p>
                        <a href="{{ route('mentoring') }}" class="btn-sm-action">Find a Mentor</a>
                    </div>
                @endif
            </div>

            <!-- MENTORING HISTORY -->
            <div class="dash-card glass-card">
                <div class="card-head">
                    <h4><i class="bi bi-clock-history"></i> Mentoring History</h4>
                </div>
                @if($sessions->count())
                    <div class="session-table-wrap">
                        <table class="session-table">
                            <thead>
                                <tr><th>Date</th><th>Day</th><th>Time</th><th>Status</th><th>Report</th></tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $s)
                                <tr>
                                    <td>{{ $s->schedule ? \Carbon\Carbon::parse($s->schedule->date)->format('d M Y') : '—' }}</td>
                                    <td>{{ $s->schedule ? \Carbon\Carbon::parse($s->schedule->date)->format('l') : '—' }}</td>
                                    <td>{{ $s->schedule ? \Carbon\Carbon::parse($s->schedule->start_time)->format('H:i') : '—' }}</td>
                                    <td>
                                        <span class="badge-base badge-{{ $s->status }}">{{ ucfirst($s->status) }}</span>
                                    </td>
                                    <td>
                                        @if($s->report)
                                            <span class="badge-base badge-approved">Submitted</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-hint">
                        <i class="bi bi-calendar-event"></i>
                        <p>No mentoring sessions yet</p>
                        <a href="{{ route('mentoring') }}" class="btn-sm-action">Book a Session</a>
                    </div>
                @endif
            </div>

        </div>

        <!-- ──── RIGHT COLUMN ──── -->
        <div class="dash-right">

            <!-- EVENT CALENDAR -->
            <div class="dash-card glass-card">
                <div class="card-head">
                    <h4><i class="bi bi-calendar-event-fill"></i> Event Calendar</h4>
                </div>
                @php
                    $calMonth = today();
                    $firstDay = $calMonth->copy()->startOfMonth();
                    $lastDay  = $calMonth->copy()->endOfMonth();
                    $startPad = $firstDay->dayOfWeek; // 0=Sun
                    $daysInMonth = $calMonth->daysInMonth;
                    $eventDates = $events->pluck('title', 'date')->mapWithKeys(fn($t, $d) => [\Carbon\Carbon::parse($d)->format('Y-m-d') => $t]);
                @endphp
                <div class="cal-header">
                    {{ $calMonth->format('F Y') }}
                </div>
                <div class="cal-grid">
                    <div class="cal-day-name">Su</div>
                    <div class="cal-day-name">Mo</div>
                    <div class="cal-day-name">Tu</div>
                    <div class="cal-day-name">We</div>
                    <div class="cal-day-name">Th</div>
                    <div class="cal-day-name">Fr</div>
                    <div class="cal-day-name">Sa</div>

                    @for($i = 0; $i < $startPad; $i++)
                        <div class="cal-cell empty"></div>
                    @endfor

                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $dateStr = $calMonth->copy()->day($d)->format('Y-m-d');
                            $hasEvent = $eventDates->has($dateStr);
                            $isToday = $dateStr === today()->format('Y-m-d');
                        @endphp
                        <div class="cal-cell {{ $hasEvent ? 'has-event' : '' }} {{ $isToday ? 'is-today' : '' }}"
                             @if($hasEvent) data-event="{{ $eventDates[$dateStr] }}" onclick="showEvent(this)" @endif>
                            {{ $d }}
                            @if($hasEvent)<span class="cal-dot"></span>@endif
                        </div>
                    @endfor
                </div>

                <!-- Event tooltip -->
                <div class="cal-event-popup" id="calPopup" style="display:none">
                    <span id="calPopupText"></span>
                </div>

                <!-- Upcoming events list -->
                @if($upcomingEvents->count())
                    <div class="upcoming-list">
                        <h6>Upcoming Events</h6>
                        @foreach($upcomingEvents as $ev)
                            <div class="upcoming-item {{ $ev->poster ? 'has-poster' : '' }}">
                                @if($ev->poster)
                                    <div class="upcoming-poster-thumb" onclick="openPosterLightbox('{{ asset($ev->poster) }}', '{{ addslashes($ev->title) }}')">
                                        <img src="{{ asset($ev->poster) }}" alt="{{ $ev->title }}">
                                        <div class="poster-zoom-icon"><i class="bi bi-arrows-fullscreen"></i></div>
                                    </div>
                                @else
                                    <div class="upcoming-date-box">
                                        <span class="up-day">{{ $ev->date->format('d') }}</span>
                                        <span class="up-month">{{ $ev->date->format('M') }}</span>
                                    </div>
                                @endif
                                <div class="upcoming-info">
                                    <strong>{{ $ev->title }}</strong>
                                    <small>
                                        <i class="bi bi-calendar3"></i> {{ $ev->date->format('d M Y') }}
                                        @if($ev->time) · <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($ev->time)->format('H:i') }} @endif
                                    </small>
                                    @if($ev->location)
                                        <small><i class="bi bi-geo-alt"></i> {{ $ev->location }}</small>
                                    @endif
                                    @if($ev->organizer)
                                        <small><i class="bi bi-people"></i> {{ $ev->organizer }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Poster Lightbox Overlay -->
            <div class="poster-lightbox" id="posterLightbox" onclick="closePosterLightbox(event)">
                <div class="lightbox-content">
                    <button class="lightbox-close" onclick="closePosterLightbox(event)"><i class="bi bi-x-lg"></i></button>
                    <img id="lightboxImg" src="" alt="">
                    <div class="lightbox-actions">
                        <span class="lightbox-title" id="lightboxTitle"></span>
                        <a id="lightboxDownload" href="" download class="lightbox-btn"><i class="bi bi-download"></i> Download</a>
                    </div>
                </div>
            </div>

            <!-- PSP APPLICATION -->
            <div class="dash-card glass-card">
                <div class="card-head">
                    <h4><i class="bi bi-mortarboard-fill"></i> PSP Application</h4>
                </div>
                @if($pspApplication)
                    <div class="psp-status-box">
                        <span class="psp-badge badge-{{ $pspApplication->status === 'review' ? 'revision' : $pspApplication->status }}">
                            {{ ucfirst($pspApplication->status) }}
                        </span>
                    </div>
                    <div class="psp-details">
                        @if($pspApplication->scholarship)
                            <div class="psp-row"><span>Scholarship</span><strong>{{ $pspApplication->scholarship->title }}</strong></div>
                        @endif
                        @if($pspApplication->studyPlan?->program)
                            <div class="psp-row"><span>Program</span><strong>{{ $pspApplication->studyPlan->program->name }}</strong></div>
                        @endif
                    </div>
                    <a href="{{ route('psp') }}" class="btn-sm-action mt-4" style="width: 100%;">View Application</a>
                @else
                    <div class="empty-hint">
                        <i class="bi bi-mortarboard"></i>
                        <p>No PSP application submitted yet</p>
                        <a href="{{ route('psp') }}" class="btn-sm-action">Start PSP</a>
                    </div>
                @endif
            </div>



        </div>

    </div>
</div>

<!-- Score Update Modal -->
<div class="modal fade" id="scoreModal" tabindex="-1" aria-labelledby="scoreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('dashboard.update-english-score') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="scoreModalLabel">Update English Score</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="toefl_score" class="form-label">TOEFL Score</label>
            <input type="number" step="0.01" class="form-control" id="toefl_score" name="toefl_score" value="{{ $user->toefl_score }}">
            <div class="form-text">e.g. 500, 550, 600</div>
          </div>
          <div class="mb-3">
            <label for="ielts_score" class="form-label">IELTS Score</label>
            <input type="number" step="0.01" class="form-control" id="ielts_score" name="ielts_score" value="{{ $user->ielts_score }}">
            <div class="form-text">e.g. 6.5, 7.0, 7.5</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

@include('sections.dashboard.styles')

<script>
function openScoreModal() {
    var modal = new bootstrap.Modal(document.getElementById('scoreModal'));
    modal.show();
}

function showEvent(el) {
    const popup = document.getElementById('calPopup');
    const text = document.getElementById('calPopupText');
    text.textContent = el.dataset.event;
    popup.style.display = 'block';
    setTimeout(() => popup.style.display = 'none', 3000);
}

function openPosterLightbox(src, title) {
    const lb = document.getElementById('posterLightbox');
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxTitle').textContent = title;
    document.getElementById('lightboxDownload').href = src;
    lb.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closePosterLightbox(e) {
    if (e && e.target.closest('.lightbox-content') && !e.target.closest('.lightbox-close')) return;
    const lb = document.getElementById('posterLightbox');
    lb.classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePosterLightbox(null);
});
</script>

</section>