{{-- Flash messages --}}
    @if(session('draft_saved'))
        <div class="bg-green-50 border-b border-green-200 px-6 py-3 text-[13px] text-green-800 flex items-center gap-2">
            <i class="ti ti-circle-check"></i> {{ session('draft_saved') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-b border-red-200 px-6 py-3 text-[13px] text-red-800 flex items-center gap-2">
            <i class="ti ti-alert-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('verified'))
        <div class="bg-green-50 border-b border-green-200 px-6 py-3 text-[13px] text-green-800 flex items-center gap-2">
            <i class="ti ti-circle-check"></i> {{ session('verified') }}
        </div>
    @endif
