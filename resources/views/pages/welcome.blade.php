{{-- resources/views/pages/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'NCEEIC | Powering Nigeria\'s Energy Future')

@php
    $newsArticles = \App\Models\Article::published()->latest()->take(3)->get();
@endphp

@section('content')

{{-- ═══════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════ --}}
<section class="hero-section relative overflow-hidden" style="background-image: url('{{ asset('img/solar-panels.jpg') }}'); background-size: cover; background-position: center;">
    {{-- Green overlay --}}
    <div class="absolute inset-0 bg-leaf-green/85 z-10"></div>

    {{-- decorative rings --}}
    <div class="absolute -right-[120px] -top-[120px] w-[520px] h-[520px] rounded-full border-[55px] border-gold/[0.07] pointer-events-none"></div>
    <div class="absolute right-[60px] -bottom-[80px] w-[280px] h-[280px] rounded-full border-[35px] border-gold/[0.05] pointer-events-none"></div>

    <div class="relative max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-[1fr_0.9fr] gap-14 items-center px-6 py-[100px] md:py-[150px] z-20">

        {{-- Left: copy --}}
        <div>
            <div class="hero-badge animate-fade-up delay-[50ms]">
                <i class="ti ti-shield-check text-[12px]"></i>
                Official Platform
            </div>

            <h1 class="text-[28px] md:text-[43px] font-bold text-white leading-[1.2] mb-5 animate-fade-up delay-[150ms]">
                Powering Nigeria's<br>
                <span class="text-gold2">Energy Future</span><br>
                Through Policy &amp; Innovation
            </h1>

            <p class="text-white/70 text-[14.5px] leading-[1.78] mb-8 max-w-[480px] animate-fade-up delay-[250ms]">
                The National Committee on Energy Efficiency, Innovation, and Certification coordinates
                renewable energy initiatives, certification standards, and sustainable development
                programmes across Nigeria.
            </p>

            <div class="flex flex-wrap gap-3 animate-fade-up delay-[350ms]">
                <a href="#mandate" class="btn-primary">
                    <i class="ti ti-arrow-right"></i> Explore Our Mandate
                </a>
                <a href="/portal/apply" class="btn-outline">
                    <i class="ti ti-file-text"></i> Apply for Solarization
                </a>
            </div>
        </div>

        {{-- Right: stats card --}}
        <div class="animate-slide-l delay-[250ms]">
            <div class="bg-white/[0.06] border border-white/10 rounded-xl p-[35px]">
                <div class="text-gold2 text-[11px] uppercase tracking-[1.2px] font-bold mb-6 flex items-center gap-2">
                    {{-- <span class="w-[10px] h-[0.5px] bg-gold2 inline-block"></span> --}}
                    Key Impact Figures
                </div>

                <div class="grid grid-cols-3 gap-3">
                    @foreach([
                        ['12',  'Stakeholders Engaged'],
                        ['5',   'Active Programmes'],
                        ['5%',  'Renewable Increase'],
                    ] as $stat)
                    <div class="bg-white/[0.07] border border-white/[0.07] rounded-lg px-3 py-[25px] text-center">
                        <div class="text-[26px] font-bold text-white">{{ $stat[0] }}</div>
                        <div class="text-[11px] text-white/50 mt-1 leading-[1.3]">{{ $stat[1] }}</div>
                    </div>
                    @endforeach
                </div>

                <div class="flex gap-3 items-start mt-8 bg-gold/10 border border-gold/20 rounded-lg p-3">
                    <i class="ti ti-speakerphone text-gold2 text-[15px] mt-[1px] flex-shrink-0"></i>
                    <p class="text-white/80 text-[12.5px] leading-[1.5]">
                        <strong class="text-gold-light">Application Open:</strong>
                        2026 Solarization Initiative for Hospitals commences 15th June 2026.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     MANDATE STRIP
═══════════════════════════════════════════════ --}}
<div class="bg-dark-green px-6 md:px-[100px] py-[30px]">
    <div class="max-w-[1400px] mx-auto grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([
            ['ti-solar-panel',      'Renewable Energy',      'Solar, wind, hydro & biomass'],
            ['ti-certificate',      'Certification',         'Quality & safety compliance'],
            ['ti-bulb',             'Innovation Initiatives',     'R&D and technology funding'],
            ['ti-building-hospital','Hospital Solarisation', 'Healthcare energy access'],
        ] as $item)
        <div class="reveal flex items-center gap-3 px-5 [&:not(:last-child)]:border-r border-white/10">
            <div class="w-[38px] h-[38px] bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="ti {{ $item[0] }} text-gold2 text-[18px]"></i>
            </div>
            <div>
                <div class="text-white text-[13px] font-semibold">{{ $item[1] }}</div>
                <div class="text-white/55 text-[11.5px] mt-[2px]">{{ $item[2] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     ABOUT
═══════════════════════════════════════════════ --}}
<section class="px-6 md:px-[100px] py-[100px]" id="about">
    <div class="max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-[100px] items-center">

        {{-- Visual card --}}
        <div class="reveal bg-[#0d2225] rounded-xl p-9 min-h-[350px] flex flex-col justify-end bg-cover bg-center relative overflow-hidden" style="background-image: url('{{ asset('img/ministry-of-science.webp') }}');">
            <div class="absolute inset-0 bg-black/40 rounded-xl"></div>
            <div class="relative z-10">
                <i class="ti ti-solar-panel-2 text-[72px] text-white/[0.07] mb-auto pb-5 block"></i>
                <div class="bg-white/[25%] border border-white/10 rounded-lg p-4">
                    <p class="text-white/80 text-[13px] leading-[1.55]">
                        Established under the
                        <span class="text-gold2 font-semibold">Federal Ministry of Innovation Science and Technology</span>,
                        NCEEIC serves as the apex coordinating body for Nigeria's clean energy
                        transition - including the national Hospital Solarisation Programme.
                    </p>
                </div>
            </div>
        </div>

        {{-- Text --}}
        <div class="reveal">
            <div class="sec-label">About NCEEIC</div>
            <h2 class="sec-title text-[#1e700f]">A Strategic Government Body for Nigeria's Energy Sector</h2>
            <p class="sec-desc">
                We coordinate, promote, and oversee initiatives related to renewable energy,
                energy efficiency, technological innovation, and certification standards within
                Nigeria — including targeted programmes for public healthcare infrastructure.
            </p>
            <ul class="mt-6 flex flex-col gap-4 list-none">
                @foreach([
                    ['Expertise in Renewable Energy',         'Deep knowledge navigating the complexities of renewable energy technologies and implementation across Nigeria\'s unique landscape.'],
                    ['Cutting-Edge Technology Integration',   'Leveraging the latest advancements in energy technology to provide effective, sustainable solutions across all sectors.'],
                    ['Strong Certification Standards',        'Robust certification processes ensuring all energy products and services meet international safety and reliability benchmarks.'],
                ] as $point)
                <li class="flex gap-3 items-start">
                    <div class="w-[22px] h-[22px] bg-slate2/10 rounded-full flex items-center justify-center flex-shrink-0 mt-[2px]">
                        <i class="ti ti-check text-slate2 text-[11px]"></i>
                    </div>
                    <div>
                        <div class="text-[14px] font-bold text-dark-green">{{ $point[0] }}</div>
                        <div class="text-[13.5px] text-muted mt-[2px] leading-[1.55]">{{ $point[1] }}</div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<section class="bg-offwhite px-6 md:px-[100px] py-[100px]" id="leadership">
    <div class="max-w-[1400px] mx-auto">

        {{-- Section header --}}
        <div class="reveal text-center mb-14">
            <div class="sec-label justify-center">Our Leadership</div>
            <h2 class="sec-title max-w-[520px] mx-auto">Guided by Experienced Leadership</h2>
            <p class="sec-desc mx-auto">
                NCEEIC is led by dedicated professionals committed to driving Nigeria's
                energy efficiency and renewable energy agenda.
            </p>
        </div>

        {{-- Leader card --}}
        <div class="reveal max-w-[960px] mx-auto">
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-border grid grid-cols-1 md:grid-cols-[370px_1fr]">

                {{-- Photo column --}}
                <div class="relative bg-[#0d2225] flex flex-col items-center justify-end min-h-[420px] overflow-hidden">
                    {{-- Decorative background ring --}}
                    <div class="absolute -top-16 -left-16 w-[280px] h-[280px] rounded-full border-[40px] border-gold/10 pointer-events-none"></div>
                    <div class="absolute -bottom-10 -right-10 w-[200px] h-[200px] rounded-full border-[30px] border-white/5 pointer-events-none"></div>

                    {{-- Photo --}}
                    <img
                        src="{{ asset('img/amb-chijioke-nwadavid.jpeg') }}"
                        alt="Hon. Chijioke Emmanuel NwaDavid — National Coordinator, NCEEIC"
                        class="absolute inset-0 w-full h-full object-cover object-top opacity-90"
                    >

                    {{-- Name plate overlay at bottom of photo --}}
                    <div class="relative z-10 w-full bg-gradient-to-t from-[#0d2225]/95 via-[#0d2225]/60 to-transparent px-6 pt-16 pb-6">
                        <div class="inline-flex items-center gap-2 bg-gold/20 border border-gold/30 text-gold2 text-[11px] font-bold px-3 py-1 rounded-full tracking-[0.5px] mb-3">
                            <i class="ti ti-star-filled text-[10px]"></i> National Coordinator
                        </div>
                        <h3 class="text-white text-[18px] font-bold leading-[1.25]">
                            Hon. Chijioke Emmanuel<br>NwaDavid
                        </h3>
                        <p class="text-white/55 text-[12px] mt-1">
                            National Committee on Energy Efficiency, <br/> Innovation, and Certification, Nigeria.
                        </p>
                    </div>
                </div>

                {{-- Bio column --}}
                <div class="p-8 md:p-10 flex flex-col justify-center">

                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12.5 h-12.5 bg-dark-green rounded-lg flex items-center justify-center shrink-0">
                            <i class="ti ti-user-star text-gold2 text-[20px]"></i>
                        </div>
                        <div>
                            <div class="text-[13px] font-bold text-dark-green uppercase tracking-[0.8px]">Office of the National Coordinator</div>
                            <div class="text-[12px] text-muted">National Committee on Energy Efficiency, <br/> Innovation, and Certification, Nigeria.</div>
                        </div>
                    </div>

                    <p class="text-muted text-[14px] leading-[1.8] mb-6">
                        The National Committee on Energy Efficiency, Innovation, and Certification Nigeria
                        is headed by the <strong class="text-dark-green font-semibold">National Coordinator, Hon. Chijioke Emmanuel NwaDavid</strong>.
                        Under his leadership, NCEEIC coordinates Nigeria's renewable energy initiatives,
                        drives innovation across the energy sector, and ensures the implementation of
                        robust certification standards that meet international benchmarks.
                    </p>

                    <p class="text-muted text-[14px] leading-[1.8] mb-8">
                        Hon. NwaDavid brings strategic vision and strong institutional leadership to
                        NCEEIC's mission of facilitating sustainable development including the
                        pioneering Hospital Solarization Programme, which is providing clean,
                        reliable energy to public hospitals across Nigeria.
                    </p>

                    {{-- Key roles / highlights --}}
                    {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
                        @foreach([
                            ['ti-bolt',             'Energy Policy Leadership'],
                            ['ti-building-hospital','Hospital Solarization Drive'],
                            ['ti-certificate',      'Certification Standards'],
                            ['ti-users',            'Stakeholder Coordination'],
                        ] as $role)
                        <div class="flex items-center gap-3 bg-offwhite rounded-lg px-4 py-3">
                            <div class="w-[32px] h-[32px] bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                <i class="ti {{ $role[0] }} text-[16px] text-dark-green"></i>
                            </div>
                            <span class="text-[13px] font-semibold text-dark-green">{{ $role[1] }}</span>
                        </div>
                        @endforeach
                    </div> --}}

                    {{-- Contact / quote strip --}}
                    <div class=" bg-gold/5 rounded-lg px-5 py-4">
                        <p class="text-[13.5px] text-dark-green font-medium leading-[1.65] italic">
                            "Nigeria may be a developing country, but not a dumping ground for substandard renewable energy products."
                        </p>
                        <div class="mt-2 text-[12px] text-muted font-semibold">
                            - Hon. Chijioke Emmanuel NwaDavid, National Coordinator
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     SERVICES / MANDATE
═══════════════════════════════════════════════ --}}
<section class="bg-offwhite px-6 md:px-[100px] py-[100px]" id="mandate">
    <div class="max-w-[1400px] mx-auto">
        <div class="reveal text-center mb-10">
            <div class="sec-label justify-center">Our Mandate</div>
            <h2 class="sec-title max-w-[500px] mx-auto">What We Do for Nigeria's Energy Future</h2>
            <p class="sec-desc mx-auto">
                From policy coordination to hospital solarisation - our six core programmes
                drive Nigeria's clean energy transition.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['ti-solar-panel',  'Promote Renewable Energy',    'Facilitating integration of solar, wind, hydro, and biomass sources, playing a crucial role in Nigeria\'s shift to sustainable energy.',  false],
                ['ti-settings',     'Enhance Energy Efficiency',   'Developing policies and programmes to improve energy utilisation efficiency across various sectors, ensuring a sustainable and economic approach.', false],
                ['ti-bulb',         'Foster Innovation',           'Supporting R&D in innovative energy technologies to stimulate growth and practical solutions tailored to Nigeria\'s unique needs.',             false],
                ['ti-certificate',  'Standards & Certification',   'Establishing rigorous standards to ensure the quality, safety, and reliability of energy products and services across the nation.',             false],
                ['ti-hierarchy',    'Policy Coordination',         'Harmonising efforts among government bodies, private stakeholders, and international partners to align with national energy goals.',            false],
                ['ti-building-hospital', 'Hospital Solarisation Programme', 'A dedicated initiative that enables public hospitals to apply for solarisation funding, ensuring reliable power for critical healthcare.', true],
            ] as $svc)

            @if($svc[3])
            {{-- Featured card --}}
            <div class="reveal relative bg-white border-[1.5px] border-gold rounded-xl p-[26px] cursor-pointer hover:shadow-lg transition-shadow overflow-hidden group">
                <div class="absolute top-0 right-0 bg-gold text-dark-green text-[10.5px] font-bold px-3 py-1 rounded-bl-lg tracking-[0.5px]">FEATURED</div>
                <div class="w-[44px] h-[44px] bg-gold/10 rounded-lg flex items-center justify-center mb-4">
                    <i class="ti {{ $svc[0] }} text-[21px] text-gold"></i>
                </div>
                <div class="text-[14.5px] font-bold text-dark-green mb-2">{{ $svc[1] }}</div>
                <div class="text-[13px] text-muted leading-[1.65]">{{ $svc[2] }}</div>
                <a href="#portal" class="inline-flex items-center gap-1 text-gold text-[12.5px] font-bold mt-4 no-underline">
                    Apply now <i class="ti ti-arrow-right text-[12px]"></i>
                </a>
            </div>
            @else
            {{-- Regular card --}}
            <div class="reveal bg-white border border-border rounded-xl p-[26px] cursor-pointer hover:shadow-lg hover:border-[#c5cede] transition-all group">
                <div class="w-[44px] h-[44px] bg-slate2/[0.07] rounded-lg flex items-center justify-center mb-4">
                    <i class="ti {{ $svc[0] }} text-[21px] text-slate2"></i>
                </div>
                <div class="text-[14.5px] font-bold text-dark-green mb-2">{{ $svc[1] }}</div>
                <div class="text-[13px] text-muted leading-[1.65]">{{ $svc[2] }}</div>
                <a href="#" class="inline-flex items-center gap-1 text-gold text-[12.5px] font-bold mt-4 no-underline">
                    Learn more <i class="ti ti-arrow-right text-[12px]"></i>
                </a>
            </div>
            @endif

            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     STATISTICS
═══════════════════════════════════════════════ --}}
<section class="bg-[#0d2225] px-6 md:px-[100px] py-[100px]">
    <div class="max-w-[1400px] mx-auto">
        <div class="reveal text-center mb-10">
            <div class="sec-label justify-center !text-gold2 before:!bg-gold2">Our Statistics</div>
            <h2 class="sec-title !text-white">Impact Across Nigeria's Energy Sector</h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['ti-users',            '12',  '',  'Stakeholders Engaged'],
                ['ti-bolt',             '5',   '%', 'Renewable Energy Increase'],
                ['ti-file-certificate', '5',   '',  'Active Programmes Launched'],
                ['ti-building-hospital','3',   '%', 'Energy Efficiency Improvements'],
            ] as $stat)
            <div class="reveal bg-white/[0.05] border border-white/[0.07] rounded-xl p-7 text-center">
                <i class="ti {{ $stat[0] }} text-[22px] text-white/20 block mb-3"></i>
                <div class="text-[40px] font-bold text-gold2 leading-none">
                    {{ $stat[1] }}<span class="text-[22px]">{{ $stat[2] }}</span>
                </div>
                <div class="text-white/55 text-[13px] mt-2 leading-[1.4]">{{ $stat[3] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     PORTAL CTA
═══════════════════════════════════════════════ --}}
<section class="bg-white px-6 md:px-[100px] py-[100px]" id="portal">
    <div class="max-w-[1400px] mx-auto">
        <div class="reveal bg-[#0d2225] rounded-2xl grid grid-cols-1 lg:grid-cols-[1fr_auto] gap-10 items-center p-[52px]">

            <div>
                <div class="sec-label !text-gold2 before:!bg-gold2">Hospital Solarisation Initiative Portal</div>
                <h2 class="sec-title !text-white">Apply for Solarisation Funding</h2>
                <p class="sec-desc !text-white/65 !max-w-full">
                    Public hospitals across Nigeria can apply for NCEEIC's Solarisation Initiative.
                    Register your institution, submit documentation, and track your application through our secure portal.
                </p>
                <div class="flex flex-col gap-3 mt-6">
                    @foreach([
                        ['1', 'Register your hospital and create an institutional account'],
                        ['2', 'Complete the application and upload required documents'],
                        ['3', 'Track application status and receive updates via your dashboard'],
                    ] as $step)
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-gold/20 rounded-full flex items-center justify-center text-[12px] font-bold text-gold2 flex-shrink-0">
                            {{ $step[0] }}
                        </div>
                        <span class="text-white/72 text-[13.5px]">{{ $step[1] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col gap-3 flex-shrink-0">
                <a href="#" class="pbtn bg-gold text-dark-green hover:bg-gold2">
                    <i class="ti ti-building-hospital"></i> Hospital Registration
                </a>
                <a href="#" class="pbtn border border-white/20 text-white hover:bg-white/[0.06]">
                    <i class="ti ti-login"></i> Sign In to Portal
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     HOSPITAL DASHBOARD PREVIEW
═══════════════════════════════════════════════ --}}
<section class="bg-offwhite px-6 md:px-[100px] py-[100px]">
    <div class="max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-11 items-start">

        {{-- Left: description --}}
        <div class="reveal">
            <div class="sec-label">Portal Preview</div>
            <h2 class="sec-title">Hospital Initiative Dashboard</h2>
            <p class="sec-desc">
                Once registered, your hospital gets a personalised dashboard to manage your
                solarisation application from submission to approval.
            </p>
            <ul class="mt-5 flex flex-col gap-4 list-none">
                @foreach([
                    'Real-time application tracking',
                    'Secure document upload & management',
                    'Direct communication with NCEEIC reviewers',
                    'Disbursement and reporting tools',
                ] as $feat)
                <li class="flex gap-3 items-center">
                    <div class="w-[22px] h-[22px] bg-slate2/10 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-check text-slate2 text-[11px]"></i>
                    </div>
                    <span class="text-[14px] font-bold text-dark-green">{{ $feat }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Right: mock dashboard card --}}
        <div class="reveal bg-white border border-border rounded-xl p-7">

            {{-- Header --}}
            <div class="flex items-start justify-between mb-5">
                <div>
                    <div class="text-[14px] font-bold text-dark-green">General Hospital Lagos</div>
                    <div class="text-[12px] text-muted mt-[2px]">Application ID: HSP-2025-00142</div>
                </div>
                <span class="bg-slate2/[0.08] text-slate2 text-[11px] font-bold px-3 py-1 rounded-full tracking-[0.5px] whitespace-nowrap">
                    Under Review
                </span>
            </div>

            {{-- Progress --}}
            <div class="flex justify-between text-[12px] text-muted mb-[6px]">
                <span>Application progress</span>
                <span class="font-bold text-dark-green">72%</span>
            </div>
            <div class="h-[6px] bg-[#E8EDF4] rounded-full overflow-hidden">
                <div class="h-full bg-gold rounded-full w-[72%] progress-bar-animated"></div>
            </div>

            {{-- Stats grid --}}
            <div class="grid grid-cols-2 gap-3 mt-5">
                @foreach([
                    ['Grid Status',  'Connected'],
                    ['Capacity needed',  '120 kW'],
                    ['Beds served',      '340'],
                    ['Stage',            'Technical Review'],
                ] as $hs)
                <div class="bg-offwhite rounded-lg p-[14px]">
                    <div class="text-[11.5px] text-muted mb-1">{{ $hs[0] }}</div>
                    <div class="text-[18px] font-bold text-dark-green">{{ $hs[1] }}</div>
                </div>
                @endforeach
            </div>

            {{-- Documents --}}
            <div class="mt-4 flex flex-col gap-2">
                @foreach([
                    ['ti-file-check', 'text-[#1B6B3A]', 'CAC / Registration certificate',      'Verified',  'bg-[#EBF7F0] text-[#1B6B3A]'],
                    ['ti-file-check', 'text-[#1B6B3A]', 'Energy audit report',                 'Verified',  'bg-[#EBF7F0] text-[#1B6B3A]'],
                    ['ti-file-time',  'text-gold',       'State Ministry endorsement letter',   'Pending',   'bg-[#FDF3E0] text-[#8B5E0A]'],
                    ['ti-file-plus',  'text-muted',      'Bank account verification',           'Required',  'bg-[#F0F3F8] text-slate2'],
                ] as $doc)
                <div class="flex items-center gap-3 px-3 py-[10px] border border-border rounded-lg text-[13px]">
                    <i class="ti {{ $doc[0] }} {{ $doc[1] }} text-[16px] flex-shrink-0"></i>
                    <span class="text-text flex-1">{{ $doc[2] }}</span>
                    <span class="text-[11.5px] font-bold px-[10px] py-[3px] rounded-full whitespace-nowrap {{ $doc[4] }}">
                        {{ $doc[3] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     NEWS & EVENTS
═══════════════════════════════════════════════ --}}
<section class="px-6 md:px-[100px] py-[100px]" id="news">
    <div class="max-w-[1400px] mx-auto">
        <div class="reveal flex justify-between items-end mb-9">
            <div>
                <div class="sec-label">News &amp; Events</div>
                <h2 class="sec-title !mb-0">Latest from NCEEIC</h2>
            </div>
            <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-1 text-gold text-[12.5px] font-bold no-underline">
                View all <i class="ti ti-arrow-right text-[12px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($newsArticles as $article)
            <a href="{{ route('articles.show', $article) }}" class="group">
                <div class="reveal border border-border rounded-xl overflow-hidden bg-white cursor-pointer hover:shadow-lg transition-shadow">
                    <div class="h-[220px] overflow-hidden flex items-center justify-center bg-gray-200">
                        <img src="{{ asset('img/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                    </div>
                    <div class="p-5">
                        <div class="text-[11px] text-slate2 font-bold uppercase tracking-[0.8px] mb-2">{{ $article->category }}</div>
                        <div class="text-[14px] font-semibold text-dark-green leading-[1.45] mb-3">{{ $article->title }}</div>
                        <div class="flex items-center gap-1 text-[12px] text-muted">
                            <i class="ti ti-calendar text-[12px]"></i> {{ $article->published_at->format('j M Y') }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Scroll-triggered reveal
const observer = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('visible'), i * 60);
            observer.unobserve(e.target);
        }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush
