<div class="max-w-[760px] mx-auto px-4 py-10">

    {{-- Progress --}}
    <div class="mb-8 flex items-center gap-3">
        @foreach(['Account & Pre-eligibility', 'Application Form', 'Document Upload'] as $i => $label)
        <div class="flex items-center {{ $i < 2 ? 'flex-1' : '' }}">
            <div class="flex items-center gap-2">
                <div @class([
                    'w-8 h-8 rounded-full flex items-center justify-center text-[13px] font-bold flex-shrink-0',
                    'bg-dark-green text-white' => true,
                ])>
                    @if($i < 2) <i class="ti ti-check text-[14px]"></i>
                    @else 3
                    @endif
                </div>
                <span class="text-[12px] font-semibold hidden md:block text-dark-green">{{ $label }}</span>
            </div>
            @if($i < 2)<div class="flex-1 h-[2px] bg-dark-green mx-3"></div>@endif
        </div>
        @endforeach
    </div>

    @if($application)
    <div class="bg-green-50 border border-green-200 rounded-xl p-5 mb-6 flex items-center gap-4">
        <div class="w-14 h-14 bg-dark-green rounded-full flex items-center justify-center flex-shrink-0">
            <i class="ti ti-trophy text-gold2 text-[26px]"></i>
        </div>
        <div>
            <div class="text-[15px] font-bold text-dark-green">Congratulations — You Qualify!</div>
            <div class="text-[13px] text-green-700 mt-1">
                Your application scored <strong>{{ $application->score_percentage }}%</strong>
                ({{ $application->total_score }}/100 points).
                Please upload the required documents below to complete your application.
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-border overflow-hidden">
        <div class="bg-dark-green px-8 py-6">
            <h1 class="text-white text-[20px] font-bold">Step 3: Document Upload</h1>
            <p class="text-white/60 text-[13px] mt-1">
                Upload supporting documents. Accepted formats: PDF, Word, Excel. Max 10MB per file.
            </p>
        </div>

        <form wire:submit="submit" class="px-8 py-8">

            <div class="flex flex-col gap-5">

                @php
                $docConfig = [
                    ['financial_statements',      'Financial Statements (Last 3 Years)',  true,  'Balance sheets, income statements for the last 3 fiscal years.'],
                    ['energy_consumption_report',  'Energy Consumption Report',            true,  'Monthly/annual energy usage data.'],
                    ['fuel_expenditure_report',    'Fuel Expenditure Report',              true,  'Diesel and fuel purchase records.'],
                    ['iso_certification',          'ISO 7101:2023 Certification Evidence', false, 'Certificate or evidence of compliance (if applicable).'],
                    ['management_certifications',  'Management Certifications',            false, 'Any relevant management or quality certifications.'],
                    ['cofinancing_proof',          'Co-financing Proof',                  true,  'Evidence of co-financing commitment (letter, bank statement, etc.)'],
                ];
                @endphp

                @foreach($docConfig as [$field, $label, $required, $hint])
                <div class="border border-border rounded-xl p-5">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <div class="text-[14px] font-semibold text-dark-green">
                                {{ $label }}
                                @if($required) <span class="text-red-500">*</span> @endif
                            </div>
                            <div class="text-[12px] text-muted mt-1">{{ $hint }}</div>
                        </div>
                        @if(isset($uploadedDocs[$field]))
                        <span class="bg-green-100 text-green-700 text-[11px] font-bold px-3 py-1 rounded-full whitespace-nowrap flex items-center gap-1">
                            <i class="ti ti-check text-[11px]"></i> Previously Uploaded
                        </span>
                        @endif
                    </div>

                    <div class="mt-3">
                        {{-- Upload zone: green border + bg when file selected, dashed grey when empty --}}
                        <label @class([
                            'flex items-center gap-3 cursor-pointer border-2 rounded-lg p-4 transition-colors',
                            'border-leaf-green bg-green-50'  => $this->{$field} !== null,
                            'border-dashed border-border hover:border-dark-green hover:bg-green-50' => $this->{$field} === null,
                        ])>
                            {{-- Icon --}}
                            <div @class([
                                'w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0',
                                'bg-leaf-green/20' => $this->{$field} !== null,
                                'bg-offwhite'      => $this->{$field} === null,
                            ])>
                                <i @class([
                                    'ti text-[20px]',
                                    'ti-file-check text-leaf-green' => $this->{$field} !== null,
                                    'ti-cloud-upload text-muted'    => $this->{$field} === null,
                                ])></i>
                            </div>

                            {{-- Text --}}
                            <div class="flex-1 min-w-0">
                                @if($this->{$field})
                                    {{-- Show actual filename, truncated if long --}}
                                    <div class="text-[13px] font-semibold text-leaf-green truncate">
                                        {{ $this->{$field}->getClientOriginalName() }}
                                    </div>
                                    <div class="text-[11px] text-green-600 mt-0.5">
                                        {{ number_format($this->{$field}->getSize() / 1024, 1) }} KB
                                        · {{ strtoupper($this->{$field}->getClientOriginalExtension()) }}
                                        · <span class="underline">Change file</span>
                                    </div>
                                @else
                                    <div class="text-[13px] font-medium text-navy">
                                        Click to upload or drag &amp; drop
                                    </div>
                                    <div class="text-[11px] text-muted mt-0.5">
                                        PDF, DOC, DOCX, XLS, XLSX — max 10MB
                                    </div>
                                @endif
                            </div>

                            <input wire:model="{{ $field }}"
                                   type="file"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx"
                                   class="hidden">
                        </label>

                        {{-- Loading indicator with guaranteed spinning animation --}}
                        <div wire:loading wire:target="{{ $field }}"
                             class="flex items-center justify-center gap-2 text-[12px] text-muted mt-2">
                            <svg class="upload-spinner w-4 h-4 text-dark-green inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Uploading, please wait...
                        </div>

                        @error($field) <div class="portal-error mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Confirmation --}}
            <div class="mt-7 bg-offwhite rounded-xl p-5">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input wire:model="confirmed" type="checkbox"
                           class="w-5 h-5 rounded border-border text-dark-green focus:ring-dark-green mt-0.5 flex-shrink-0">
                    <span class="text-[13.5px] text-dark-green leading-[1.6]">
                        I confirm that all information provided in this application is accurate and complete to the best of my knowledge.
                        I understand that providing false information may result in disqualification.
                    </span>
                </label>
                @error('confirmed') <div class="portal-error mt-2">{{ $message }}</div> @enderror
            </div>

            {{-- Submit --}}
            <div class="mt-6 flex justify-end">
                <button type="submit"
                        class="bg-dark-green text-white px-10 py-3 rounded-lg text-[14px] font-bold hover:bg-leaf-green flex items-center gap-2"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-70">

                    {{-- Spinner shown while submitting --}}
                    <svg wire:loading wire:target="submit"
                         class="upload-spinner w-5 h-5 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>

                    <span wire:loading wire:target="submit">Submitting...</span>
                    <span wire:loading.remove wire:target="submit">
                        <i class="ti ti-send"></i> Submit Final Application
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
