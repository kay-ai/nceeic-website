@extends('layouts.app')

@section('title', 'News & Articles | NCEEIC')

@section('content')

{{-- ═══════════════════════════════════════════════
     PAGE HEADER
═══════════════════════════════════════════════ --}}
<section class="bg-dark-green px-6 md:px-[100px] py-[80px] md:py-[120px]">
    <div class="max-w-[1400px] mx-auto">
        <div class="flex items-center gap-2 mb-4 text-white/60">
            <a href="/" class="hover:text-white transition-colors">Home</a>
            <i class="ti ti-chevron-right text-[12px]"></i>
            <span class="text-white">News & Articles</span>
        </div>

        <h1 class="text-[32px] md:text-[48px] font-bold text-white leading-[1.15] mb-4">
            Latest News & Articles
        </h1>
        <p class="text-white/65 text-[16px] max-w-[600px]">
            Stay updated with the latest developments in Nigeria's energy sector, NCEEIC initiatives, and industry news.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     ARTICLES GRID
═══════════════════════════════════════════════ --}}
<section class="px-6 md:px-[100px] py-[100px]">
    <div class="max-w-[1400px] mx-auto">
        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
                @foreach($articles as $article)
                <a href="{{ route('articles.show', $article) }}" class="group">
                    <div class="reveal border border-border rounded-xl overflow-hidden bg-white cursor-pointer hover:shadow-lg transition-shadow h-full flex flex-col">
                        <div class="h-[220px] overflow-hidden flex items-center justify-center bg-gray-200">
                            <img src="{{ asset('img/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="text-[11px] text-slate2 font-bold uppercase tracking-[0.8px] mb-2">{{ $article->category }}</div>
                            <div class="text-[14px] font-semibold text-dark-green leading-[1.45] mb-3 flex-1 line-clamp-3">{{ $article->title }}</div>
                            <p class="text-[13px] text-muted leading-[1.55] mb-3 line-clamp-2">{{ $article->excerpt }}</p>
                            <div class="flex items-center gap-1 text-[12px] text-muted">
                                <i class="ti ti-calendar text-[12px]"></i> {{ $article->published_at->format('M j, Y') }}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($articles->hasPages())
            <div class="flex justify-center mt-12">
                {{ $articles->links() }}
            </div>
            @endif
        @else
            <div class="text-center py-20">
                <i class="ti ti-inbox text-[64px] text-slate2/20 block mb-4"></i>
                <h3 class="text-[20px] font-bold text-dark-green mb-2">No Articles Yet</h3>
                <p class="text-muted">Check back soon for updates from NCEEIC.</p>
            </div>
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     CTA SECTION
═══════════════════════════════════════════════ --}}
<section class="bg-offwhite px-6 md:px-[100px] py-[100px]">
    <div class="max-w-[800px] mx-auto text-center">
        <h2 class="sec-title mb-3">Stay Connected with NCEEIC</h2>
        <p class="sec-desc mb-8">
            Subscribe to our newsletter to receive updates about energy initiatives, certification programmes, and hospital solarisation opportunities.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <input type="email" placeholder="Enter your email" class="px-4 py-3 rounded-lg border border-border focus:outline-none focus:ring-2 focus:ring-gold/50 flex-1 max-w-[300px]">
            <button class="btn-primary">
                <i class="ti ti-mail"></i> Subscribe
            </button>
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
