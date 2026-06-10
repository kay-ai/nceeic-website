<div class="max-w-200 mx-auto px-4 py-10">

    {{-- Progress indicator --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            @foreach(['Account & Pre-eligibility', 'Application Form', 'Document Upload'] as $i => $label)
            <div class="flex items-center {{ $i < 2 ? 'flex-1' : '' }}">
                <div class="flex items-center gap-2">
                    <div @class([
                        'w-8 h-8 rounded-full flex items-center justify-center text-[13px] font-bold flex-shrink-0',
                        'bg-dark-green text-white' => $i === 0,
                        'bg-border text-muted' => $i !== 0,
                    ])>{{ $i + 1 }}</div>
                    <span @class([
                        'text-[12px] font-semibold hidden md:block',
                        'text-dark-green' => $i === 0,
                        'text-muted' => $i !== 0,
                    ])>{{ $label }}</span>
                </div>
                @if($i < 2)
                <div class="flex-1 h-[2px] bg-border mx-3"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Disqualified state --}}
    @if($submitted && count($ineligibleReasons) > 0)
    <div class="bg-white rounded-2xl border border-border p-8 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <i class="ti ti-x text-red-500 text-[28px]"></i>
        </div>
        <h2 class="text-[20px] font-bold text-dark-green mb-3">Pre-eligibility Check Failed</h2>
        <p class="text-muted text-[14px] mb-6">
            Unfortunately, your hospital does not meet the minimum eligibility criteria
            for the Solarisation Programme at this time.
        </p>
        <div class="bg-red-50 border border-red-200 rounded-xl p-5 text-left mb-6">
            <div class="text-[13px] font-bold text-red-700 mb-3">Reasons for ineligibility:</div>
            @foreach($ineligibleReasons as $reason)
            <div class="flex gap-2 items-start text-[13px] text-red-700 mb-2">
                <i class="ti ti-point-filled text-[10px] mt-[5px] flex-shrink-0"></i>
                {{ $reason }}
            </div>
            @endforeach
        </div>
        <p class="text-muted text-[13px] mb-5">
            If you believe this is an error or wish to request a manual review,
            please contact us at:
        </p>
        <a href="mailto:grants@nceeic.org"
           class="inline-flex items-center gap-2 bg-dark-green text-white px-6 py-3 rounded-lg text-[14px] font-semibold no-underline hover:bg-leaf-green">
            <i class="ti ti-mail"></i> grants@nceeic.org
        </a>
    </div>
    @else

    {{-- Form card --}}
    <div class="bg-white rounded-2xl border border-border overflow-hidden mb-20">
        <div class="bg-dark-green px-8 py-6">
            <h1 class="text-white text-[20px] font-bold">Step 1: Account Setup &amp; Pre-eligibility</h1>
            <p class="text-white/60 text-[13px] mt-1">
                Create your account and verify your hospital meets the basic eligibility requirements.
            </p>
        </div>

        <form wire:submit="submit" class="px-8 py-8">
            {{-- ── Account Information ── --}}
            <div class="mb-8">
                <h3 class="text-[15px] font-bold text-dark-green mb-5 pb-3 border-b border-border flex items-center gap-2">
                    <i class="ti ti-building-hospital text-gold"></i> Hospital Account Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div class="md:col-span-2">
                        <label class="portal-label">Hospital Name <span class="text-red-500">*</span></label>
                        <input wire:model="hospital_name" type="text" class="portal-input" placeholder="e.g. General Hospital Lagos">
                        @error('hospital_name') <div class="portal-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="portal-label">CAC Number <span class="text-red-500">*</span></label>
                        <input wire:model="cac_number" type="text" class="portal-input" placeholder="e.g. RC-123456">
                        @error('cac_number') <div class="portal-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="portal-label">Phone Number <span class="text-red-500">*</span></label>
                        <input wire:model="phone" type="tel" class="portal-input" placeholder="+234 800 000 0000">
                        @error('phone') <div class="portal-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="portal-label">Email Address <span class="text-red-500">*</span></label>
                        <input wire:model="email" type="email" class="portal-input" placeholder="admin@hospital.ng">
                        @error('email') <div class="portal-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="portal-label">Password <span class="text-red-500">*</span></label>
                        <input wire:model="password" type="password" class="portal-input" placeholder="Min. 8 characters">
                        @error('password') <div class="portal-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="portal-label">Confirm Password <span class="text-red-500">*</span></label>
                        <input wire:model="password_confirmation" type="password" class="portal-input" placeholder="Repeat password">
                    </div>
                </div>
            </div>

            {{-- ── Pre-eligibility ── --}}
            <div class="mb-8">
                <h3 class="text-[15px] font-bold text-dark-green mb-2 pb-3 border-b border-border flex items-center gap-2">
                    <i class="ti ti-checklist text-gold"></i> Pre-eligibility Check
                </h3>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-5 text-[13px] text-green-800">
                    <i class="ti ti-info-circle mr-1"></i>
                    To qualify, your hospital must have <strong>at least 50 beds</strong> and
                    <strong>at least 20% of revenue from health insurance</strong>.
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    <div>
                        <label class="portal-label">Ownership Type <span class="text-red-500">*</span></label>
                        <select wire:model="ownership_type" class="portal-input">
                            <option value="">Select...</option>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                        </select>
                        @error('ownership_type') <div class="portal-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="portal-label">Number of Beds <span class="text-red-500">*</span></label>
                        <input wire:model="number_of_beds" type="number" min="0" class="portal-input" placeholder="e.g. 120">
                        @error('number_of_beds') <div class="portal-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="portal-label">% Revenue from Health Insurance <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input wire:model="insurance_revenue_pct" type="number" min="0" max="100" step="0.01"
                                   class="portal-input pr-8" placeholder="e.g. 35">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted text-[13px]">%</span>
                        </div>
                        @error('insurance_revenue_pct') <div class="portal-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-between pt-4 border-t border-border">
                <p class="text-[12px] text-muted">
                    Already have an account?
                    <a href="{{ route('portal.login') }}" class="text-gold font-semibold hover:underline">Sign in here</a>
                </p>
                <button type="submit"
                        class="bg-dark-green text-white px-8 py-3 rounded-lg text-[14px] font-bold hover:bg-leaf-green transition-colors flex items-center gap-2"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-70">

                    <svg wire:loading wire:target="submit"
                        class="upload-spinner w-5 h-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>

                    <span wire:loading wire:target="submit">Checking...</span>
                    <span wire:loading.remove wire:target="submit">
                        Check Eligibility &amp; Continue <i class="ti ti-arrow-right"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
