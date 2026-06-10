<div class="max-w-[860px] mx-auto px-4 py-10">
    {{-- Progress --}}
    <div class="mb-8 flex items-center gap-3">
        @foreach(['Account & Pre-eligibility', 'Application Form', 'Document Upload'] as $i => $label)
        <div class="flex items-center {{ $i < 2 ? 'flex-1' : '' }}">
            <div class="flex items-center gap-2">
                <div @class([
                    'w-8 h-8 rounded-full flex items-center justify-center text-[13px] font-bold flex-shrink-0',
                    'bg-dark-green text-white' => $i <= 1,
                    'bg-border text-muted' => $i > 1,
                ])>
                    @if($i === 0) <i class="ti ti-check text-[14px]"></i>
                    @else {{ $i + 1 }}
                    @endif
                </div>
                <span @class(['text-[12px] font-semibold hidden md:block', 'text-dark-green' => $i <= 1, 'text-muted' => $i > 1])>
                    {{ $label }}
                </span>
            </div>
            @if($i < 2)<div class="flex-1 h-[2px] {{ $i === 0 ? 'bg-dark-green' : 'bg-border' }} mx-3"></div>@endif
        </div>
        @endforeach
    </div>

    @if(session('draft_saved'))
    <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-[13px] text-green-800 mb-5 flex items-center gap-2">
        <i class="ti ti-circle-check"></i> Draft saved successfully.
    </div>
    @endif

    <form wire:submit="submit">

        {{-- ── A. Hospital Information ── --}}
        <div class="bg-white rounded-2xl border border-border mb-5 overflow-hidden">
            <div class="px-7 py-4 bg-dark-green border-b border-border flex items-center gap-2">
                <span class="w-7 h-7 bg-offwhite text-dark-green rounded-full flex items-center justify-center text-[12px] font-bold">A</span>
                <h3 class="font-bold text-offwhite text-[15px]">Hospital Information</h3>
            </div>
            <div class="px-7 py-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="portal-label">Hospital Name <span class="text-red-500">*</span></label>
                    <input wire:model="hospital_name" type="text" class="portal-input">
                    @error('hospital_name') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Hospital Type <span class="text-red-500">*</span></label>
                    <select wire:model="hospital_type" class="portal-input">
                        <option value="">Select type...</option>
                        @foreach(['Teaching Hospital','General Hospital','Specialist Hospital','Cottage Hospital','Clinic'] as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                    @error('hospital_type') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Year of Establishment <span class="text-red-500">*</span></label>
                    <input wire:model="year_established" type="number" min="1900" max="{{ date('Y') }}" class="portal-input" placeholder="e.g. 1998">
                    @error('year_established') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
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
                    <label class="portal-label">Facility Ownership Status <span class="text-red-500">*</span></label>
                    <select wire:model="facility_ownership" class="portal-input">
                        <option value="">Select...</option>
                        <option value="owned">Owned</option>
                        <option value="leased">Leased</option>
                    </select>
                    @error('facility_ownership') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">State <span class="text-red-500">*</span></label>
                    <select wire:model="state" class="portal-input">
                        <option value="">Select state...</option>
                        @foreach($nigerianStates as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('state') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">LGA <span class="text-red-500">*</span></label>
                    <input wire:model="lga" type="text" class="portal-input" placeholder="Local Government Area">
                    @error('lga') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="portal-label">Full Address <span class="text-red-500">*</span></label>
                    <input wire:model="address" type="text" class="portal-input" placeholder="Street address">
                    @error('address') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Number of Beds <span class="text-red-500">*</span></label>
                    <input wire:model="number_of_beds" type="number" min="0" class="portal-input">
                    @error('number_of_beds') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Number of ICU Beds <span class="text-red-500">*</span></label>
                    <input wire:model="number_of_icu_beds" type="number" min="0" class="portal-input">
                    @error('number_of_icu_beds') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Number of Active Operating Rooms <span class="text-red-500">*</span></label>
                    <input wire:model="number_of_active_ors" type="number" min="0" class="portal-input">
                    @error('number_of_active_ors') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- ── B. Revenue Information ── --}}
        <div class="bg-white rounded-2xl border border-border mb-5 overflow-hidden">
            <div class="px-7 py-4 bg-dark-green border-b border-border flex items-center gap-2">
                <span class="w-7 h-7 bg-offwhite text-dark-green rounded-full flex items-center justify-center text-[12px] font-bold">B</span>
                <h3 class="font-bold text-offwhite text-[15px]">Revenue Information</h3>
            </div>
            <div class="px-7 py-6 grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="portal-label">Total Annual Revenue (₦) <span class="text-red-500">*</span></label>
                    <input wire:model="total_revenue" type="number" min="0" step="0.01" class="portal-input" placeholder="0.00">
                    @error('total_revenue') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Revenue from Cash (₦) <span class="text-red-500">*</span></label>
                    <input wire:model="revenue_from_cash" type="number" min="0" step="0.01" class="portal-input" placeholder="0.00">
                    @error('revenue_from_cash') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Revenue from Health Insurance (₦) <span class="text-red-500">*</span></label>
                    <input wire:model="revenue_from_insurance" type="number" min="0" step="0.01" class="portal-input" placeholder="0.00">
                    @error('revenue_from_insurance') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                @if($total_revenue > 0 && $revenue_from_insurance > 0)
                <div class="md:col-span-3">
                    <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-[13px] text-green-800">
                        <i class="ti ti-calculator mr-1"></i>
                        Calculated insurance revenue: <strong>{{ round(($revenue_from_insurance / $total_revenue) * 100, 1) }}%</strong>
                        @if(($revenue_from_insurance / $total_revenue) * 100 >= 20)
                            <span class="text-green-700 font-semibold ml-2"><i class="ti ti-check"></i> Meets threshold</span>
                        @else
                            <span class="text-red-600 font-semibold ml-2"><i class="ti ti-x"></i> Below 20% threshold</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ── C. Energy Consumption ── --}}
        <div class="bg-white rounded-2xl border border-border mb-5 overflow-hidden">
            <div class="px-7 py-4 bg-dark-green border-b border-border flex items-center gap-2">
                <span class="w-7 h-7 bg-offwhite text-dark-green rounded-full flex items-center justify-center text-[12px] font-bold">C</span>
                <h3 class="font-bold text-offwhite text-[15px]">Energy Consumption Data</h3>
            </div>
            <div class="px-7 py-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="portal-label">Grid Connectivity Status <span class="text-red-500">*</span></label>
                    <select wire:model="grid_connectivity" class="portal-input">
                        <option value="">Select...</option>
                        <option value="connected">Connected</option>
                        <option value="not_connected">Not Connected</option>
                        <option value="partial">Partial</option>
                    </select>
                    @error('grid_connectivity') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Monthly Diesel Consumption (litres) <span class="text-red-500">*</span></label>
                    <input wire:model="monthly_diesel_consumption" type="number" min="0" step="0.01" class="portal-input" placeholder="0">
                    @error('monthly_diesel_consumption') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Monthly Energy Bill (₦) <span class="text-red-500">*</span></label>
                    <input wire:model="monthly_energy_bill" type="number" min="0" step="0.01" class="portal-input" placeholder="0.00">
                    @error('monthly_energy_bill') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Total Monthly Energy Consumption (kWh) <span class="text-red-500">*</span></label>
                    <input wire:model="monthly_energy_consumption_kwh" type="number" min="0" step="0.01" class="portal-input" placeholder="0">
                    @error('monthly_energy_consumption_kwh') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- ── D. Management & Compliance ── --}}
        <div class="bg-white rounded-2xl border border-border mb-5 overflow-hidden">
            <div class="px-7 py-4 bg-dark-green border-b border-border flex items-center gap-2">
                <span class="w-7 h-7 bg-offwhite text-dark-green rounded-full flex items-center justify-center text-[12px] font-bold">D</span>
                <h3 class="font-bold text-offwhite text-[15px]">Management &amp; Compliance</h3>
            </div>
            <div class="px-7 py-6 grid grid-cols-1 gap-5">
                <div>
                    <label class="portal-label">ISO 7101:2023 Compliance Status <span class="text-red-500">*</span></label>
                    <select wire:model="iso_compliance" class="portal-input md:w-1/2">
                        <option value="none">Not Compliant</option>
                        <option value="partial">Partially Compliant</option>
                        <option value="full">Fully Compliant</option>
                    </select>
                    @error('iso_compliance') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Management Practices Description <span class="text-red-500">*</span></label>
                    <textarea wire:model="management_practices" rows="4" class="portal-input"
                              placeholder="Describe your hospital's management practices and governance structure..."></textarea>
                    @error('management_practices') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Maintenance Policies <span class="text-red-500">*</span></label>
                    <textarea wire:model="maintenance_policies" rows="4" class="portal-input"
                              placeholder="Describe your maintenance policies and procedures..."></textarea>
                    @error('maintenance_policies') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- ── E. Financial Capacity ── --}}
        <div class="bg-white rounded-2xl border border-border mb-5 overflow-hidden">
            <div class="px-7 py-4 bg-dark-green border-b border-border flex items-center gap-2">
                <span class="w-7 h-7 bg-offwhite text-dark-green rounded-full flex items-center justify-center text-[12px] font-bold">E</span>
                <h3 class="font-bold text-offwhite text-[15px]">Financial Capacity</h3>
            </div>
            <div class="px-7 py-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="portal-label">Co-financing Commitment (% of project cost) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input wire:model="cofinancing_commitment_pct" type="number" min="0" max="100" step="0.01"
                               class="portal-input pr-8" placeholder="e.g. 15">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted text-[13px]">%</span>
                    </div>
                    @error('cofinancing_commitment_pct') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="portal-label">Source of Co-financing <span class="text-red-500">*</span></label>
                    <input wire:model="cofinancing_source" type="text" class="portal-input"
                           placeholder="e.g. State Government, NGO, Internal Funds">
                    @error('cofinancing_source') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input wire:model="has_maintenance_reserve" type="checkbox"
                               class="w-5 h-5 rounded border-border text-dark-green focus:ring-dark-green">
                        <span class="text-[14px] text-dark-green font-medium">We have dedicated maintenance reserve funds</span>
                    </label>
                </div>
                @if($has_maintenance_reserve)
                <div>
                    <label class="portal-label">Maintenance Reserve Amount (₦)</label>
                    <input wire:model="maintenance_reserve_amount" type="number" min="0" step="0.01" class="portal-input" placeholder="0.00">
                    @error('maintenance_reserve_amount') <div class="portal-error">{{ $message }}</div> @enderror
                </div>
                @endif
            </div>
        </div>

        {{-- ── F. Additional Comments ── --}}
        <div class="bg-white rounded-2xl border border-border mb-6 overflow-hidden">
            <div class="px-7 py-4 bg-dark-green border-b border-border flex items-center gap-2">
                <span class="w-7 h-7 bg-offwhite text-dark-green rounded-full flex items-center justify-center text-[12px] font-bold">F</span>
                <h3 class="font-bold text-offwhite text-[15px]">Additional Comments</h3>
            </div>
            <div class="px-7 py-6">
                <textarea wire:model="additional_comments" rows="4" class="portal-input"
                          placeholder="Any additional information you'd like to share with the review committee..."></textarea>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between">
            <button type="button" wire:click="saveDraft"
                    class="border border-border text-muted px-6 py-3 rounded-lg text-[14px] font-semibold hover:bg-dark-green hover:text-offwhite cursor-pointer flex items-center gap-2"
                    wire:loading.attr="disabled">

                <svg wire:loading wire:target="saveDraft"
                    class="upload-spinner w-5 h-5 text-muted"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>

                <span wire:loading.remove wire:target="saveDraft">
                    <i class="ti ti-device-floppy"></i>
                </span>

                <span wire:loading wire:target="saveDraft">Saving...</span>
                <span wire:loading.remove wire:target="saveDraft">Save Draft</span>

            </button>

            <button type="submit"
                    class="bg-dark-green text-white px-8 py-3 rounded-lg text-[14px] font-bold hover:bg-leaf-green cursor-pointer flex items-center gap-2"
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

                <span wire:loading wire:target="submit">Scoring...</span>
                <span wire:loading.remove wire:target="submit">
                    Submit for Scoring <i class="ti ti-arrow-right"></i>
                </span>

            </button>
        </div>
    </form>
</div>
