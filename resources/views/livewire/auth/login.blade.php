<div class="max-w-[460px] mx-auto px-4 py-16">
    <div class="bg-white rounded-2xl border border-border overflow-hidden shadow-sm">

        {{-- Header --}}
        <div class="bg-dark-green px-8 py-7 text-center">
            <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="ti ti-building-hospital text-gold2 text-[28px]"></i>
            </div>
            <h1 class="text-white text-[20px] font-bold">Hospital Portal Sign In</h1>
            <p class="text-white/55 text-[13px] mt-1">NCEEIC Solarisation Grant Programme</p>
        </div>

        <div class="px-8 py-8">

            <form wire:submit="login" class="flex flex-col gap-5">

                {{-- Email --}}
                <div>
                    <label class="portal-label">Email Address</label>
                    <input wire:model="email"
                           type="email"
                           class="portal-input @error('email') !border-red-400 @enderror"
                           placeholder="your@hospital.ng"
                           autocomplete="email"
                           autofocus>
                    @error('email')
                        <div class="portal-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="portal-label">Password</label>
                    <div class="relative">
                        <input wire:model="password"
                               type="password"
                               id="portal-password"
                               class="portal-input pr-11 @error('password') !border-red-400 @enderror"
                               placeholder="••••••••"
                               autocomplete="current-password">
                        {{-- Toggle visibility --}}
                        <button type="button"
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-muted hover:text-navy">
                            <i class="ti ti-eye text-[18px]" id="eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="portal-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-[13px] text-muted cursor-pointer select-none">
                        <input wire:model="remember"
                               type="checkbox"
                               class="w-4 h-4 rounded border-border text-dark-green focus:ring-dark-green">
                        Remember me
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-dark-green text-white py-3 rounded-lg text-[14px] font-bold hover:bg-leaf-green transition-colors flex items-center justify-center gap-2"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-70">

                    <svg wire:loading wire:target="login"
                         class="upload-spinner w-5 h-5 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>

                    <span wire:loading wire:target="login">Signing in...</span>
                    <span wire:loading.remove wire:target="login">
                        <i class="ti ti-login mr-1"></i> Sign In to Portal
                    </span>
                </button>

            </form>

            {{-- Register link --}}
            <div class="text-center mt-6 pt-5 border-t border-border text-[13px] text-muted">
                New hospital?
                <a href="{{ route('portal.apply') }}" class="text-gold font-semibold hover:underline">
                    Register &amp; Apply
                </a>
            </div>

        </div>
    </div>

    {{-- Info note --}}
    <div class="mt-5 bg-green-50 border border-green-200 rounded-xl p-4 text-[12.5px] text-green-800 flex gap-3">
        <i class="ti ti-info-circle text-green-500 text-[16px] flex-shrink-0 mt-0.5"></i>
        <p>
            This portal is for <strong>registered hospitals</strong> participating in the
            NCEEIC Solarisation Grant Programme. If you need assistance, contact
            <a href="mailto:grants@nceeic.org" class="underline font-semibold">grants@nceeic.org</a>.
        </p>
    </div>

    @push('scripts')
    <script>
        function togglePassword() {
            const input = document.getElementById('portal-password');
            const icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ti-eye', 'ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.replace('ti-eye-off', 'ti-eye');
            }
        }
    </script>
    @endpush
</div>
