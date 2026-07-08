<x-filament-panels::page>
@php
    $authUser = auth()->user();
    $greetingHour = now()->hour;
    $greeting = match(true) {
        $greetingHour < 12 => 'Good Morning',
        $greetingHour < 17 => 'Good Afternoon',
        default            => 'Good Evening',
    };
    $years = range(date('Y'), date('Y') - 3);
@endphp
<div class="ed-welcome-banner">
    <div class="ed-welcome-left">
        <div class="ed-welcome-icon">
            <x-heroicon-o-user-circle style="width:2.5rem;height:2.5rem;"/>
        </div>
        <div class="ed-welcome-text">
            <span class="ed-welcome-greeting">{{ $greeting }}, <strong>{{ $authUser->name }}</strong> 👋</span>
            <span class="ed-welcome-role">
                <span class="ed-role-badge">Mentor</span>
                SOVIA — Scholarship & Mentoring Platform
            </span>
        </div>
    </div>
    <div class="ed-welcome-right">
        <span class="ed-welcome-date">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>
</div>

<div class="ed-filter-bar">
    <span class="ed-filter-label">
        <x-heroicon-m-funnel style="width: 1.25rem; height: 1.25rem; color: #3b82f6;"/> 
        Filter Period:
    </span>
    <div class="ed-filter-group">
        <select wire:model.live="selectedYear" class="ed-select">
            @foreach($years as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>
        <select wire:model.live="selectedMonth" class="ed-select">
            <option value="">All Months</option>
            @foreach(['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $num => $name)
                <option value="{{ $num }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <span class="ed-filter-period-info">
        Showing data:
        <strong>
            @if($selectedMonth)
                {{ ['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'][$selectedMonth] }}
            @else All Months
            @endif
            {{ $selectedYear }}
        </strong>
    </span>
</div>

<div class="mt-4 mb-4">
    @livewire(\App\Livewire\MentorStatsWidget::class, ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth])
</div>

<div class="mt-4 mb-4">
    @livewire(\App\Livewire\MentorActionRequiredWidget::class, ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth])
</div>

<div class="mt-4 mb-4">
    @livewire(\App\Livewire\MentorMenteesProgressWidget::class, ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth])
</div>

<style>
    /* CSS Variables for Light/Dark Mode */
    :root {
        --bg-panel: #ffffff;
        --bg-body: #f8fafc;
        --bg-muted: #f1f5f9;
        --border-color: #e2e8f0;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --ring-color: rgba(0,0,0,0.05);
    }
    .dark {
        --bg-panel: #18181b; 
        --bg-body: #09090b; 
        --bg-muted: rgba(255,255,255,0.05);
        --border-color: rgba(255,255,255,0.1);
        --text-main: #f4f4f5; 
        --text-muted: #a1a1aa; 
        --ring-color: rgba(255,255,255,0.1);
    }
    
    .ed-welcome-banner {
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #1d4ed8 100%);
        border-radius: 0.75rem; padding: 1.25rem 1.75rem;
        box-shadow: 0 4px 15px rgba(37,99,235,0.3); margin-bottom: 1.5rem;
        color: #fff;
    }
    .ed-welcome-left { display: flex; align-items: center; gap: 1rem; }
    .ed-welcome-icon { 
        display: flex; align-items: center; justify-content: center;
        width: 3.5rem; height: 3.5rem; border-radius: 50%;
        background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);
        flex-shrink: 0; color: #fff;
    }
    .ed-welcome-text { display: flex; flex-direction: column; gap: 0.25rem; }
    .ed-welcome-greeting { font-size: 1.25rem; font-weight: 600; color: #fff; }
    .ed-welcome-greeting strong { font-weight: 700; }
    .ed-welcome-role { font-size: 0.8rem; color: rgba(255,255,255,0.75); display: flex; align-items: center; gap: 0.5rem; }
    .ed-role-badge {
        background: rgba(255,255,255,0.2); color: #fff; font-weight: 600;
        padding: 0.15rem 0.6rem; border-radius: 9999px; font-size: 0.7rem;
        letter-spacing: 0.04em; text-transform: uppercase; border: 1px solid rgba(255,255,255,0.3);
    }
    .ed-welcome-right { }
    .ed-welcome-date { font-size: 0.85rem; color: rgba(255,255,255,0.8); font-weight: 500; }

    /* Filter Bar */
    .ed-filter-bar {
        display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;
        background: var(--bg-panel); border-radius: 0.75rem; padding: 1rem 1.5rem;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); border: 1px solid var(--border-color);
        margin-bottom: 1.5rem; color: var(--text-main);
    }
    .ed-filter-label { font-weight: 600; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }
    .ed-filter-group { display: flex; gap: 0.75rem; align-items: center; }
    .ed-select {
        padding: 0.5rem 2rem 0.5rem 1rem; border: 1px solid var(--border-color);
        border-radius: 0.5rem; font-size: 0.875rem; color: var(--text-main);
        background: var(--bg-panel); cursor: pointer; transition: all .2s; outline: none;
    }
    .ed-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 1px #3b82f6; }
    .ed-filter-period-info { font-size: 0.875rem; color: var(--text-muted); background: var(--bg-muted); padding: 0.35rem 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border-color); }
    .ed-filter-period-info strong { color: var(--text-main); margin-left: 0.25rem; }
</style>
</x-filament-panels::page>
