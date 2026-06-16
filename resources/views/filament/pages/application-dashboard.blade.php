<x-filament-panels::page>
    {{-- Stat Cards --}}
    <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        @foreach($this->stats as $stat)
            @php
                [$border, $from, $to, $text] = match($stat['color']) {
                    'info', 'blue'  => ['#bfdbfe', '#eff6ff', '#dbeafe', '#2563eb'],
                    'yellow'        => ['#fde68a', '#fefce8', '#fef9c3', '#ca8a04'],
                    'warning'       => ['#fcd34d', '#fffbeb', '#fef3c7', '#d97706'],
                    'success'       => ['#6ee7b7', '#ecfdf5', '#d1fae5', '#059669'],
                    'danger'        => ['#fda4af', '#fff1f2', '#ffe4e6', '#e11d48'],
                    default         => ['#e5e7eb', '#f9fafb', '#f3f4f6', '#374151'],
                };
            @endphp
            <div style="border: 1px solid {{ $border }}; background: linear-gradient(135deg, {{ $from }}, {{ $to }}); border-radius: 0.75rem; padding: 1.25rem 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.07); position: relative; overflow: hidden;">
                <div style="position: absolute; right: -1rem; top: -1rem; width: 5rem; height: 5rem; border-radius: 9999px; background: {{ $border }}; opacity: 0.3;"></div>
                <p style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #6b7280; margin: 0;">{{ $stat['label'] }}</p>
                <p style="font-size: 2.25rem; font-weight: 800; color: {{ $text }}; margin: 0.5rem 0 0;">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Two-column section --}}
    <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">

        {{-- Recent Submissions --}}
        <div style="background: #fff; border-radius: 0.75rem; border: 1px solid #f3f4f6; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
            <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between;">
                <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #1f2937; margin: 0;">Recent Submissions</h3>
                <span style="font-size: 0.75rem; color: #9ca3af;">Latest activity</span>
            </div>
            {{-- Search --}}
            <div style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #f9fafb; background: #fafafa;">
                <input
                    wire:model.live.debounce.300ms="searchRecent"
                    type="text"
                    placeholder="Search hospital or App ID…"
                    style="width: 100%; padding: 0.4rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; font-size: 0.8rem; color: #374151; outline: none; background: #fff;"
                />
            </div>
            <table style="width: 100%; font-size: 0.875rem; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">
                        <th style="padding: 0.65rem 1.5rem; text-align: left;">Hospital</th>
                        <th style="padding: 0.65rem 1rem; text-align: left;">App ID</th>
                        <th style="padding: 0.65rem 1rem; text-align: left;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $filteredRecent = collect($this->recentApplications)->filter(fn($a) =>
                            !$searchRecent ||
                            str_contains(strtolower($a['hospital_name']), strtolower($searchRecent)) ||
                            str_contains(strtolower($a['application_id']), strtolower($searchRecent))
                        );
                    @endphp
                    @forelse($filteredRecent as $app)
                        <tr style="border-top: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem 1.5rem; font-weight: 500; color: #111827;">{{ $app['hospital_name'] }}</td>
                            <td style="padding: 0.75rem 1rem; color: #9ca3af; font-family: monospace; font-size: 0.75rem;">{{ $app['application_id'] }}</td>
                            <td style="padding: 0.75rem 1rem;">
                                <span style="display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.2rem 0.65rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                                    <span style="width: 0.4rem; height: 0.4rem; border-radius: 9999px; background: #3b82f6; display: inline-block;"></span>
                                    {{ ucfirst(str_replace('_', ' ', $app['status'])) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 2.5rem 1.5rem; text-align: center; color: #9ca3af; font-size: 0.85rem; font-style: italic;">
                                {{ $searchRecent ? 'No results for "' . $searchRecent . '"' : 'No applications yet' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Qualified Applications --}}
        <div style="background: #fff; border-radius: 0.75rem; border: 1px solid #f3f4f6; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
            <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between;">
                <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #1f2937; margin: 0;">Qualified Applications</h3>
                <span style="font-size: 0.75rem; color: #9ca3af;">By score</span>
            </div>
            {{-- Search --}}
            <div style="padding: 0.75rem 1.5rem; border-bottom: 1px solid #f9fafb; background: #fafafa;">
                <input
                    wire:model.live.debounce.300ms="searchQualified"
                    type="text"
                    placeholder="Search hospital…"
                    style="width: 100%; padding: 0.4rem 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; font-size: 0.8rem; color: #374151; outline: none; background: #fff;"
                />
            </div>
            <table style="width: 100%; font-size: 0.875rem; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">
                        <th style="padding: 0.65rem 1.5rem; text-align: left;">Hospital</th>
                        <th style="padding: 0.65rem 1rem; text-align: right;">Score</th>
                        <th style="padding: 0.65rem 1rem; text-align: left;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $filteredQualified = collect($this->qualifiedApplications)->filter(fn($a) =>
                            !$searchQualified ||
                            str_contains(strtolower($a['hospital_name']), strtolower($searchQualified))
                        );
                    @endphp
                    @forelse($filteredQualified as $app)
                        <tr style="border-top: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem 1.5rem; font-weight: 500; color: #111827;">{{ $app['hospital_name'] }}</td>
                            <td style="padding: 0.75rem 1rem; text-align: right; font-weight: 700; color: #059669;">{{ $app['score_percentage'] }}%</td>
                            <td style="padding: 0.75rem 1rem;">
                                <span style="display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.2rem 0.65rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; background: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7;">
                                    <span style="width: 0.4rem; height: 0.4rem; border-radius: 9999px; background: #10b981; display: inline-block;"></span>
                                    Qualified
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 2.5rem 1.5rem; text-align: center; color: #9ca3af; font-size: 0.85rem; font-style: italic;">
                                {{ $searchQualified ? 'No results for "' . $searchQualified . '"' : 'No qualified applications yet' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Status Summary --}}
    <div style="background: #fff; border-radius: 0.75rem; border: 1px solid #f3f4f6; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #1f2937; margin: 0;">Application Status Summary</h3>
            <span style="font-size: 0.75rem; color: #9ca3af;">All time</span>
        </div>
        <table style="width: 100%; font-size: 0.875rem; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">
                    <th style="padding: 0.65rem 1.5rem; text-align: left;">Status</th>
                    <th style="padding: 0.65rem 1rem; text-align: center; width: 5rem;">Count</th>
                    <th style="padding: 0.65rem 1.5rem; text-align: left;">Distribution</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->statusSummary as $summary)
                    <tr style="border-top: 1px solid #f3f4f6;">
                        <td style="padding: 0.75rem 1.5rem; font-weight: 500; color: #374151;">
                            {{ ucfirst(str_replace('_', ' ', $summary['status'])) }}
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: center;">
                            <span style="display: inline-block; padding: 0.15rem 0.6rem; border-radius: 9999px; background: #f3f4f6; color: #374151; font-weight: 700; font-size: 0.75rem;">
                                {{ $summary['count'] }}
                            </span>
                        </td>
                        <td style="padding: 0.75rem 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="flex: 1; background: #f3f4f6; border-radius: 9999px; height: 0.4rem; overflow: hidden;">
                                    <div style="width: {{ $summary['percentage'] }}%; background: linear-gradient(90deg, #3b82f6, #60a5fa); height: 100%; border-radius: 9999px;"></div>
                                </div>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #6b7280; width: 2.5rem; text-align: right; white-space: nowrap;">
                                    {{ $summary['percentage'] }}%
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament-panels::page>
