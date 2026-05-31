{{-- resources/views/partials/topbar.blade.php --}}
<div class="topbar hidden md:flex items-center justify-between px-[100px] py-[7px] bg-dark-green animate-fade-in">

    {{-- Left: contact info --}}
    <div class="flex items-center gap-6">
        <div class="topbar-item">
            <i class="ti ti-mail text-gold2 text-[13px]"></i>
            <span>info@nceeic.org</span>
        </div>
        <div class="topbar-item">
            <i class="ti ti-phone text-gold2 text-[13px]"></i>
            <span>+234 809 101 0103</span>
        </div>
        <div class="topbar-item">
            <i class="ti ti-map-pin text-gold2 text-[13px]"></i>
            <span>Abuja, Federal Capital Territory</span>
        </div>
    </div>

    {{-- Right: flag + links --}}
    <div class="flex items-center gap-3">
        {{-- Nigerian flag --}}
        <div class="flex w-[22px] h-[14px] rounded-sm overflow-hidden flex-shrink-0">
            <div class="flex-1 bg-[#008751]"></div>
            <div class="flex-1 bg-white"></div>
            <div class="flex-1 bg-[#008751]"></div>
        </div>
        <a href="#" class="topbar-link">FRN Official</a>
        <a href="#" class="topbar-link">Accessibility</a>
    </div>

</div>
