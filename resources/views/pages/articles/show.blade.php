@extends('layouts.app')

@section('title', $article->title . ' | NCEEIC News')

@section('content')

{{-- ═══════════════════════════════════════════════
     ARTICLE HEADER
═══════════════════════════════════════════════ --}}
<section class="bg-dark-green px-6 md:px-[100px] py-[80px] md:py-[120px]">
    <div class="max-w-[900px] mx-auto">
        <div class="flex items-center gap-2 mb-4 text-white/60">
            <a href="/" class="hover:text-white transition-colors">Home</a>
            <i class="ti ti-chevron-right text-[12px]"></i>
            <a href="/news" class="hover:text-white transition-colors">News</a>
            <i class="ti ti-chevron-right text-[12px]"></i>
            <span class="text-white">{{ $article->title }}</span>
        </div>

        <div class="inline-flex items-center gap-2 bg-gold/20 border border-gold/30 text-gold2 text-[11px] font-bold px-3 py-1 rounded-full tracking-[0.5px] mb-6">
            <i class="ti ti-tag text-[10px]"></i> {{ $article->category }}
        </div>

        <h1 class="text-[32px] md:text-[48px] font-bold text-white leading-[1.15] mb-6">
            {{ $article->title }}
        </h1>

        <div class="flex flex-wrap gap-6 text-white/70 text-[14px]">
            <div class="flex items-center gap-2">
                <i class="ti ti-calendar"></i>
                {{ $article->published_at->format('F j, Y') }}
            </div>
            <div class="flex items-center gap-2">
                <i class="ti ti-clock"></i>
                {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min read
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     ARTICLE IMAGE
═══════════════════════════════════════════════ --}}
<div class="px-6 md:px-[100px] py-8">
    <div class="max-w-[900px] mx-auto">
        <div class="rounded-xl overflow-hidden h-[300px] md:h-[500px]">
            <img
                src="{{ asset('img/' . $article->image) }}"
                alt="{{ $article->title }}"
                class="w-full h-full object-cover"
            >
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     ARTICLE CONTENT
═══════════════════════════════════════════════ --}}
<section class="px-6 md:px-[100px] py-[100px]">
    <div class="max-w-[900px] mx-auto">
        <div class="prose prose-lg max-w-none [&_p]:mb-6 [&_h3]:mt-8 [&_h3]:mb-4 [&_ul]:mb-6 [&_ol]:mb-6 [&_li]:mb-2">
            {!! $article->content !!}
        </div>

        {{-- Share buttons --}}
        <div class="mt-12 pt-8 border-t border-border flex flex-wrap gap-4">
            <span class="text-slate2 font-semibold text-[14px]">Share this article:</span>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(route('articles.show', $article)) }}"
               target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 transition-colors text-[14px] font-medium text-slate2">
                <i class="ti ti-brand-twitter"></i> Twitter
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('articles.show', $article)) }}"
               target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 transition-colors text-[14px] font-medium text-blue-700">
                <i class="ti ti-brand-linkedin"></i> LinkedIn
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article)) }}"
               target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors text-[14px] font-medium text-blue-600">
                <i class="ti ti-brand-facebook"></i> Facebook
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     RELATED ARTICLES
═══════════════════════════════════════════════ --}}
@if($relatedArticles->count() > 0)
<section class="bg-offwhite px-6 md:px-[100px] py-[100px]">
    <div class="max-w-[1400px] mx-auto">
        <h2 class="sec-title mb-10">Related Articles</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($relatedArticles as $related)
            <a href="{{ route('articles.show', $related) }}" class="group">
                <div class="border border-border rounded-xl overflow-hidden bg-white cursor-pointer hover:shadow-lg transition-shadow h-full flex flex-col">
                    <div class="h-[200px] overflow-hidden flex items-center justify-center bg-gray-200">
                        <img src="{{ asset('img/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="text-[11px] text-slate2 font-bold uppercase tracking-[0.8px] mb-2">{{ $related->category }}</div>
                        <div class="text-[14px] font-semibold text-dark-green leading-[1.45] mb-3 flex-1">{{ $related->title }}</div>
                        <div class="flex items-center gap-1 text-[12px] text-muted">
                            <i class="ti ti-calendar text-[12px]"></i> {{ $related->published_at->format('M j, Y') }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════
     CTA SECTION
═══════════════════════════════════════════════ --}}
<section class="bg-dark-green px-6 md:px-[100px] py-[100px]">
    <div class="max-w-[800px] mx-auto text-center">
        <h2 class="sec-title !text-white mb-3">Ready to Make an Impact?</h2>
        <p class="sec-desc !text-white/65 mb-8 !max-w-full">
            Join NCEEIC in powering Nigeria's energy future. Explore our programmes or apply for the Hospital Solarisation Initiative.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="/#mandate" class="btn-primary">
                <i class="ti ti-arrow-right"></i> Explore Our Mandate
            </a>
            <a href="/#portal" class="btn-outline">
                <i class="ti ti-file-certificate"></i> Hospital Solarisation
            </a>
        </div>
    </div>
</section>

@endsection
