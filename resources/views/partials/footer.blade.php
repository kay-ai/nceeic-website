<footer class="bg-dark-green pt-14 px-6 md:px-10" id="footer">
    <div class="max-w-[1400px] mx-auto">

        {{-- Main footer grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1.4fr] gap-10 pb-12 border-b border-white/10">

            {{-- Brand column --}}
            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                    <div class="w-[38px] h-[38px] bg-white/[0.07] rounded-lg flex items-center justify-center">
                        <i class="ti ti-bolt text-gold text-[18px]"></i>
                    </div>
                    <div>
                        <div class="text-[15px] font-bold text-white">NCEEIC</div>
                        <div class="text-[10px] text-white/35">Federal Republic of Nigeria</div>
                    </div>
                </a>
                <p class="text-white/50 text-[13px] leading-[1.7] mt-4 mb-5 max-w-[260px]">
                    Committed to steering Nigeria towards energy efficiency, innovation, and sustainable development through comprehensive strategies and collaborative efforts.
                </p>
                <div class="flex flex-col gap-2">
                    <div class="flex gap-2 items-start text-white/55 text-[12.5px]">
                        <i class="ti ti-phone text-gold text-[13px] mt-[2px] flex-shrink-0"></i>
                        +234 809 101 0103
                    </div>
                    <div class="flex gap-2 items-start text-white/55 text-[12.5px]">
                        <i class="ti ti-mail text-gold text-[13px] mt-[2px] flex-shrink-0"></i>
                        info@nceeic.org
                    </div>
                    <div class="flex gap-2 items-start text-white/55 text-[12.5px]">
                        <i class="ti ti-map-pin text-gold text-[13px] mt-[2px] flex-shrink-0"></i>
                        Abuja, Federal Capital Territory, Nigeria
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <a href="#" class="soc-btn"><i class="ti ti-brand-twitter"></i></a>
                    <a href="#" class="soc-btn"><i class="ti ti-brand-instagram"></i></a>
                    <a href="#" class="soc-btn"><i class="ti ti-brand-linkedin"></i></a>
                    <a href="#" class="soc-btn"><i class="ti ti-brand-facebook"></i></a>
                </div>
            </div>

            {{-- Quick links --}}
            <div>
                <div class="footer-col-title">Quick Links</div>
                <div class="flex flex-col gap-[9px]">
                    <a href="{{ url('/') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Home</a>
                    <a href="{{ url('/#about') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> About NCEEIC</a>
                    <a href="{{ url('/#mandate') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Our Mandate</a>
                    <a href="#" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Publications</a>
                    <a href="{{ url('/#news') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> News &amp; Events</a>
                    <a href="{{ url('/#footer') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Contact</a>
                </div>
            </div>

            {{-- Services --}}
            <div>
                <div class="footer-col-title">Our Services</div>
                <div class="flex flex-col gap-[9px]">
                    <a href="{{ url('/#mandate') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Renewable Energy</a>
                    <a href="{{ url('/#mandate') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Energy Efficiency</a>
                    <a href="{{ url('/#mandate') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Foster Innovation</a>
                    <a href="{{ url('/#mandate') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Certification</a>
                    <a href="{{ url('/#mandate') }}" class="flink"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Policy Coordination</a>
                    <a href="{{ url('/#portal') }}" class="flink !text-gold2"><i class="ti ti-chevron-right text-[10px] text-gold"></i> Hospital Solarisation</a>
                </div>
            </div>

            {{-- Newsletter --}}
            <div>
                <div class="footer-col-title">Subscribe for Updates</div>
                <p class="text-white/50 text-[13px] leading-[1.65] mb-4">
                    Stay informed about upcoming events, initiatives, and insights in Nigeria's energy sector.
                </p>
                <form action="#" method="POST" @submit.prevent>
                    @csrf
                    <input type="email"
                           class="w-full bg-white/[0.06] border border-white/10 rounded-lg px-[13px] py-[10px] text-white text-[13px] mb-[9px] outline-none placeholder:text-white/30 focus:border-gold/50 focus:ring-0"
                           placeholder="Enter your email address">
                    <button type="submit"
                            class="w-full bg-gold text-dark-green border-none rounded-lg py-[10px] text-[13px] font-bold cursor-pointer hover:bg-gold2 transition-colors">
                        Subscribe Now
                    </button>
                </form>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-3 py-[18px]">
            <div class="text-white/35 text-[12px]">
                &copy; {{ date('Y') }} NCEEIC — National Committee on Energy Efficiency, Innovation &amp; Certification Nigeria
            </div>
            <div class="flex gap-5">
                <a href="#" class="text-white/35 text-[12px] hover:text-white/60 no-underline">Privacy Policy</a>
                <a href="#" class="text-white/35 text-[12px] hover:text-white/60 no-underline">Terms of Use</a>
                <a href="#" class="text-white/35 text-[12px] hover:text-white/60 no-underline">Accessibility</a>
                <a href="#" class="text-white/35 text-[12px] hover:text-white/60 no-underline">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
