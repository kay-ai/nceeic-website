@extends('layouts.portal')

@section('title', 'Application Score Result')

@php $application = Auth::guard('hospital')->user()->application; @endphp

<div class="max-w-[680px] mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl border border-border overflow-hidden shadow-sm">

        {{-- Header --}}
        <div class="bg-[#3D0000] px-8 py-8 text-center">
            <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ti ti-chart-bar text-red-300 text-[30px]"></i>
            </div>
            <h1 class="text-white text-[22px] font-bold">Score Below Threshold</h1>
            <p class="text-white/60 text-[13px] mt-2">
                Your application did not meet the minimum qualifying score of 70%.
            </p>
        </div>

        <div class="px-8 py-8">

            {{-- Score display --}}
            @if($application)
            <div class="flex items-center justify-center gap-6 bg-red-50 border border-red-200 rounded-xl p-6 mb-7">
                <div class="w-20 h-20 rounded-full border-4 border-red-400 flex items-center justify-center flex-shrink-0">
                    <div class="text-center">
                        <div class="text-[22px] font-bold text-red-600">{{ $application->score_percentage }}%</div>
                    </div>
                </div>
                <div>
                    <div class="text-[15px] font-bold text-red-700">Score: {{ $application->total_score }} / 100</div>
                    <div class="text-[13px] text-red-500 mt-1">Required: 70 points (70%)</div>
                    <div class="text-[13px] text-red-500">
                        You need {{ max(0, 70 - $application->total_score) }} more points to qualify.
                    </div>
                </div>
            </div>

            {{-- Score breakdown table --}}
            @php $breakdown = app(\App\Services\ScoringService::class)->getBreakdown($application); @endphp
            <h3 class="text-[15px] font-bold text-dark-green mb-4">Score Breakdown</h3>
            <div class="overflow-x-auto rounded-xl border border-border mb-7">
                <table class="w-full text-[13px]">
                    <thead class="bg-offwhite">
                        <tr>
                            <th class="text-left px-4 py-3 text-muted font-semibold">Criterion</th>
                            <th class="text-center px-4 py-3 text-muted font-semibold">Your Score</th>
                            <th class="text-center px-4 py-3 text-muted font-semibold">Max Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($breakdown as $row)
                        <tr @class([
                            'border-t border-border',
                            'font-bold bg-offwhite' => $row['criterion'] === 'TOTAL',
                        ])>
                            <td class="px-4 py-3 text-dark-green">{{ $row['criterion'] }}</td>
                            <td class="px-4 py-3 text-center font-bold {{ $row['score'] > 0 ? 'text-dark-green' : 'text-red-400' }}">
                                {{ $row['score'] }}
                            </td>
                            <td class="px-4 py-3 text-center text-muted">{{ $row['max'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Next steps --}}
            <div class="bg-gold/5 border border-gold/20 rounded-xl p-5 mb-6">
                <h3 class="text-[14px] font-bold text-dark-green mb-3 flex items-center gap-2">
                    <i class="ti ti-info-circle text-gold"></i> What happens next?
                </h3>
                <ul class="flex flex-col gap-2">
                    @foreach([
                        'Review the scoring criteria above to understand where your application fell short.',
                        'You may request a manual review by contacting the NCEEIC grants team.',
                        'Consider improving the identified areas and reapplying in the next application window.',
                        'Your account remains active — you can log in at any time.',
                    ] as $item)
                    <li class="flex gap-2 items-start text-[13px] text-muted">
                        <i class="ti ti-point-filled text-gold text-[10px] mt-[5px] flex-shrink-0"></i>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Request manual review --}}
            <div class="bg-dark-green/5 border border-border rounded-xl p-5 text-center">
                <div class="text-[14px] font-bold text-dark-green mb-2">Request a Manual Review</div>
                <p class="text-[13px] text-muted mb-4">
                    If you believe your score does not accurately reflect your hospital's capabilities,
                    contact our team for a manual evaluation.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="mailto:grants@nceeic.org?subject=Manual Review Request - {{ $application?->application_id }}"
                       class="inline-flex items-center justify-center gap-2 bg-dark-green text-white px-6 py-3 rounded-lg text-[13.5px] font-bold hover:bg-leaf-green no-underline">
                        <i class="ti ti-mail"></i> Email grants@nceeic.org
                    </a>
                    <a href="{{ route('portal.dashboard') }}"
                       class="inline-flex items-center justify-center gap-2 border border-border text-muted px-6 py-3 rounded-lg text-[13.5px] font-semibold hover:bg-offwhite no-underline">
                        <i class="ti ti-layout-dashboard"></i> Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
