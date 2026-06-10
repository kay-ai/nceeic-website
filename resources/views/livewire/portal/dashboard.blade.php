{{-- resources/views/livewire/portal/dashboard.blade.php --}}
<div class="max-w-[900px] mx-auto px-4 py-10">

    {{-- Welcome header --}}
    <div class="mb-8 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-[24px] font-bold text-dark-green">
                Welcome, {{ $hospital->hospital_name }}
            </h1>
            <p class="text-muted text-[14px] mt-1">
                Hospital Solarisation Grant - Application Dashboard
            </p>
        </div>

        {{-- Logout button --}}
        <form method="POST" action="{{ route('portal.logout') }}">
            @csrf
            <button type="submit"
                    class="flex items-center gap-2 border border-border bg-white text-muted text-[13px] font-semibold px-4 py-2 rounded-lg hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-colors cursor-pointer">
                <i class="ti ti-logout text-[16px]"></i>
                <span class="hidden md:inline">Sign Out</span>
            </button>
        </form>
    </div>

    {{-- ── DISQUALIFIED STATE ─────────────────────────────── --}}
    @if(!$hospital->is_eligible)

    <div class="bg-white rounded-2xl border border-red-200 overflow-hidden mb-5">

        {{-- Red header --}}
        <div class="bg-red-50 border-b border-red-200 px-6 py-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="ti ti-x text-red-500 text-[22px]"></i>
            </div>
            <div>
                <div class="text-[16px] font-bold text-red-700">Pre-eligibility Check Failed</div>
                <div class="text-[13px] text-red-500 mt-0.5">
                    Your hospital does not meet the minimum criteria for this programme.
                </div>
            </div>
        </div>

        <div class="px-6 py-6">

            {{-- Reasons --}}
            @if($hospital->ineligibility_reasons && count($hospital->ineligibility_reasons) > 0)
            <div class="bg-red-50 border border-red-200 rounded-xl p-5 mb-6">
                <div class="text-[13px] font-bold text-red-700 mb-3">Reasons for ineligibility:</div>
                <div class="flex flex-col gap-2">
                    @foreach($hospital->ineligibility_reasons as $reason)
                    <div class="flex gap-2 items-start text-[13.5px] text-red-700">
                        <i class="ti ti-point-filled text-[10px] mt-[5px] flex-shrink-0"></i>
                        {{ $reason }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Minimum requirements reminder --}}
            <div class="bg-white border border-border rounded-xl p-5 mb-6">
                <div class="text-[13px] font-bold text-navy mb-3">
                    <i class="ti ti-info-circle text-slate2 mr-1"></i>
                    Minimum requirements for eligibility:
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex gap-2 items-center text-[13.5px] text-muted">
                        <i class="ti ti-building-hospital text-slate2 text-[14px]"></i>
                        A minimum of <strong class="text-navy mx-1">50 beds</strong>
                    </div>
                    <div class="flex gap-2 items-center text-[13.5px] text-muted">
                        <i class="ti ti-heart-rate-monitor text-slate2 text-[14px]"></i>
                        At least <strong class="text-navy mx-1">20%</strong> of revenue from health insurance
                    </div>
                </div>
            </div>

            {{-- Manual review CTA --}}
            <div class="bg-gold/10 border border-gold/30 rounded-xl p-5">
                <div class="text-[14px] font-bold text-navy mb-1">
                    <i class="ti ti-mail text-gold mr-1"></i>
                    Request a Manual Review
                </div>
                <p class="text-[13px] text-muted leading-[1.65] mb-4">
                    If you believe this assessment is incorrect, or your hospital's situation has changed,
                    contact the NCEEIC grants team to request a manual review.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="mailto:grants@nceeic.org?subject=Manual Review Request - {{ $hospital->hospital_name }}"
                       class="inline-flex items-center gap-2 bg-dark-green text-white px-5 py-2.5 rounded-lg text-[13px] font-bold no-underline hover:bg-leaf-green transition-colors">
                        <i class="ti ti-mail"></i> grants@nceeic.org
                    </a>
                    <a href="tel:+2348091010103"
                       class="inline-flex items-center gap-2 border border-border bg-white text-navy px-5 py-2.5 rounded-lg text-[13px] font-bold no-underline hover:bg-offwhite transition-colors">
                        <i class="ti ti-phone"></i> +234 809 101 0103
                    </a>
                </div>
            </div>
        </div>
    </div>



    {{-- ── NO APPLICATION YET (eligible but hasn't started) ── --}}
    @elseif(!$application)

    <div class="bg-white rounded-2xl border border-border p-10 text-center">
        <div class="w-16 h-16 bg-offwhite rounded-full flex items-center justify-center mx-auto mb-5">
            <i class="ti ti-file-plus text-muted text-[28px]"></i>
        </div>
        <h2 class="text-[18px] font-bold text-dark-green mb-3">No Application Yet</h2>
        <p class="text-muted text-[14px] mb-6 max-w-[400px] mx-auto">
            You haven't started your grant application. Click below to begin the 3-step process.
        </p>
        <a href="{{ route('portal.apply.step2') }}"
           class="inline-flex items-center gap-2 bg-dark-green text-white px-8 py-3 rounded-lg text-[14px] font-bold hover:bg-leaf-green no-underline transition-colors">
            <i class="ti ti-arrow-right"></i> Start Application
        </a>
    </div>

    {{-- ── APPLICATION EXISTS ──────────────────────────────── --}}
    @else

    {{-- Application ID + Status --}}
    <div class="bg-white rounded-2xl border border-border p-6 mb-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="text-[12px] text-muted uppercase tracking-wider mb-1">Application Reference</div>
            <div class="text-[22px] font-bold text-dark-green">{{ $application->application_id }}</div>
            <div class="text-[13px] text-muted mt-1">
                Submitted: {{ $application->submitted_at ? $application->submitted_at->format('d M Y, g:ia') : 'Not yet submitted' }}
            </div>
        </div>
        <div class="flex flex-col items-start md:items-end gap-2">
            @php
            $statusColors = [
                'draft'                => 'bg-gray-100 text-gray-600',
                'submitted'            => 'bg-blue-100 text-blue-700',
                'under_review'         => 'bg-yellow-100 text-yellow-700',
                'shortlisted'          => 'bg-green-100 text-green-700',
                'rejected'             => 'bg-red-100 text-red-700',
                'site_visit_scheduled' => 'bg-purple-100 text-purple-700',
                'approved'             => 'bg-green-100 text-green-800',
            ];
            $color = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-600';
            @endphp
            <span class="text-[13px] font-bold px-4 py-2 rounded-full {{ $color }}">
                <i class="ti ti-point-filled text-[10px]"></i>
                {{ $application->status_label }}
            </span>
            @if($application->status === 'draft' && $hospital->is_eligible)
            <a href="{{ $hospital->application_step === 'step2' ? route('portal.apply.step2') : route('portal.apply.step3') }}"
               class="text-[13px] text-gold font-semibold hover:underline">
                Continue application <i class="ti ti-arrow-right text-[12px]"></i>
            </a>
            @endif
        </div>
    </div>

    {{-- Progress tracker --}}
    <div class="bg-white rounded-2xl border border-border p-6 mb-5">
        <h3 class="text-[15px] font-bold text-dark-green mb-5">Application Progress</h3>
        <div class="flex flex-col gap-3">
            @php
            $steps = [
                ['label' => 'Account Created & Pre-eligibility Passed', 'done' => true],
                ['label' => 'Application Form Submitted',               'done' => in_array($application->status, ['submitted','under_review','shortlisted','site_visit_scheduled','approved','rejected'])],
                ['label' => 'Documents Uploaded',                       'done' => $application->documents->count() > 0],
                ['label' => 'Under Review by NCEEIC',                   'done' => in_array($application->status, ['under_review','shortlisted','site_visit_scheduled','approved','rejected'])],
                ['label' => 'Shortlisted / Decision Made',              'done' => in_array($application->status, ['shortlisted','approved','rejected'])],
            ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="flex items-center gap-4">
                <div @class([
                    'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-[13px] font-bold',
                    'bg-dark-green text-white' => $step['done'],
                    'bg-border text-muted'     => !$step['done'],
                ])>
                    @if($step['done']) <i class="ti ti-check text-[14px]"></i>
                    @else {{ $i + 1 }}
                    @endif
                </div>
                <span @class([
                    'text-[14px]',
                    'text-dark-green font-semibold' => $step['done'],
                    'text-muted'                    => !$step['done'],
                ])>
                    {{ $step['label'] }}
                </span>
            </div>
            @if($i < count($steps) - 1)
            <div class="ml-4 w-[2px] h-4 {{ $step['done'] ? 'bg-dark-green' : 'bg-border' }}"></div>
            @endif
            @endforeach
        </div>
    </div>

    {{-- Score card (only if scored) --}}
    @if($application->total_score > 0)
    <div class="bg-white rounded-2xl border border-border p-6 mb-5">
        <h3 class="text-[15px] font-bold text-dark-green mb-5 flex items-center gap-2">
            <i class="ti ti-chart-bar text-gold"></i> Scoring Summary
        </h3>
        <div class="flex items-center gap-6 mb-5">
            <div class="w-20 h-20 rounded-full flex items-center justify-center flex-shrink-0
                {{ $application->is_qualified ? 'bg-green-50 border-4 border-dark-green' : 'bg-red-50 border-4 border-red-400' }}">
                <div class="text-center">
                    <div class="text-[18px] font-bold {{ $application->is_qualified ? 'text-dark-green' : 'text-red-600' }}">
                        {{ $application->score_percentage }}%
                    </div>
                </div>
            </div>
            <div>
                <div class="text-[16px] font-bold {{ $application->is_qualified ? 'text-dark-green' : 'text-red-600' }}">
                    {{ $application->is_qualified ? '✓ Qualified' : '✗ Not Qualified' }}
                </div>
                <div class="text-[13px] text-muted mt-1">
                    Score: {{ $application->total_score }} / 100 points (Pass threshold: 70%)
                </div>
            </div>
        </div>
        @if($breakdown)
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="border-b border-border">
                        <th class="text-left py-2 text-muted font-semibold">Criterion</th>
                        <th class="text-center py-2 text-muted font-semibold">Score</th>
                        <th class="text-center py-2 text-muted font-semibold">Max</th>
                        <th class="text-left py-2 text-muted font-semibold">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($breakdown as $row)
                    <tr class="{{ $row['criterion'] === 'TOTAL' ? 'border-t-2 border-border font-bold' : 'border-b border-border/50' }}">
                        <td class="py-2 text-dark-green">{{ $row['criterion'] }}</td>
                        <td class="py-2 text-center font-bold {{ $row['score'] > 0 ? 'text-dark-green' : 'text-muted' }}">{{ $row['score'] }}</td>
                        <td class="py-2 text-center text-muted">{{ $row['max'] }}</td>
                        <td class="py-2 w-32">
                            @if($row['criterion'] !== 'TOTAL')
                            <div class="h-1.5 bg-border rounded-full overflow-hidden">
                                <div class="h-full bg-dark-green rounded-full"
                                     style="width: {{ $row['max'] > 0 ? ($row['score'] / $row['max']) * 100 : 0 }}%"></div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @endif

    {{-- Documents status --}}
    <div class="bg-white rounded-2xl border border-border p-6 mb-5">
        <h3 class="text-[15px] font-bold text-dark-green mb-5 flex items-center justify-between">
            <span><i class="ti ti-files text-gold mr-2"></i> Required Documents</span>
            @if($application->is_qualified && $application->documents->count() < 6)
            <a href="{{ route('portal.apply.step3') }}"
               class="text-[13px] text-gold font-semibold hover:underline">
                Upload documents <i class="ti ti-arrow-right text-[12px]"></i>
            </a>
            @endif
        </h3>
        <div class="flex flex-col gap-3">
            @foreach($application->document_status as $doc)
            <div class="flex items-center gap-3 p-3 rounded-lg border {{ $doc['uploaded'] ? 'border-green-200 bg-green-50' : 'border-border bg-offwhite' }}">
                <i class="ti {{ $doc['uploaded'] ? 'ti-file-check text-dark-green' : 'ti-file-plus text-muted' }} text-[18px] flex-shrink-0"></i>
                <span class="flex-1 text-[13.5px] {{ $doc['uploaded'] ? 'text-dark-green font-medium' : 'text-muted' }}">
                    {{ $doc['label'] }}
                </span>
                <span @class([
                    'text-[11.5px] font-bold px-3 py-1 rounded-full',
                    'bg-green-100 text-green-700' => $doc['uploaded'],
                    'bg-gray-100 text-gray-500'   => !$doc['uploaded'],
                ])>
                    {{ $doc['uploaded'] ? 'Uploaded' : 'Required' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    @endif

    {{-- Contact / help (always visible) --}}
    <div class="bg-dark-green/5 border border-border rounded-xl p-5 text-[13px] text-muted text-center mt-5">
        <i class="ti ti-help-circle text-[16px] mr-1"></i>
        Have questions about your application? Contact the NCEEIC grants team at
        <a href="mailto:grants@nceeic.org" class="text-gold font-semibold hover:underline">grants@nceeic.org</a>
        or call <strong class="text-dark-green">+234 809 101 0103</strong>
    </div>

</div>
