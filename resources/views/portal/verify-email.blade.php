{{-- resources/views/portal/verify-email.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email — NCEEIC Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-offwhite min-h-screen">

    {{-- Portal top bar --}}
    <div class="bg-navy py-3 px-6 md:px-10 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
            <div class="w-[36px] h-[36px] bg-white/10 rounded-lg flex items-center justify-center">
                <i class="ti ti-bolt text-gold2 text-[18px]"></i>
            </div>
            <div>
                <div class="text-white font-bold text-[14px]">NCEEIC</div>
                <div class="text-white/40 text-[10px]">Hospital Solarisation Grant Portal</div>
            </div>
        </a>
        <form method="POST" action="{{ route('portal.logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-white/60 text-[13px] hover:text-white flex items-center gap-1">
                <i class="ti ti-logout"></i> Sign Out
            </button>
        </form>
    </div>

    <div class="max-w-[520px] mx-auto px-4 py-16">
        <div class="bg-white rounded-2xl border border-border overflow-hidden shadow-sm">

            {{-- Header --}}
            <div class="bg-navy px-8 py-8 text-center">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ti ti-mail text-gold2 text-[30px]"></i>
                </div>
                <h1 class="text-white text-[22px] font-bold">Verify Your Email Address</h1>
                <p class="text-white/55 text-[13px] mt-2">One more step before you continue</p>
            </div>

            <div class="px-8 py-8">

                {{-- Success message --}}
                @if(session('message'))
                <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-[13px] text-green-800 mb-6 flex items-center gap-2">
                    <i class="ti ti-circle-check text-green-600"></i>
                    {{ session('message') }}
                </div>
                @endif

                <p class="text-muted text-[14px] leading-[1.75] mb-6">
                    Thank you for registering with the NCEEIC Hospital Solarisation Grant Portal.
                    Before you can continue your application, please verify your email address by
                    clicking the link we sent to:
                </p>

                <div class="bg-offwhite border border-border rounded-lg px-4 py-3 text-center mb-6">
                    <span class="text-navy font-bold text-[15px]">
                        {{ Auth::guard('hospital')->user()->email }}
                    </span>
                </div>

                <p class="text-muted text-[13px] leading-[1.7] mb-7">
                    If you did not receive the email, check your spam/junk folder or click below
                    to resend the verification link.
                </p>

                {{-- Resend form --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="w-full bg-dark-green text-white py-3 rounded-lg text-[14px] font-bold hover:bg-leaf-green transition-colors flex items-center justify-center gap-2">
                        <i class="ti ti-send"></i> Resend Verification Email
                    </button>
                </form>

                {{-- Help text --}}
                <div class="mt-6 pt-5 border-t border-border text-center">
                    <p class="text-[13px] text-muted">
                        Wrong email address?
                        <form method="POST" action="{{ route('portal.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gold font-semibold hover:underline">
                                Sign out and start over
                            </button>
                        </form>
                    </p>
                    <p class="text-[12px] text-muted mt-3">
                        Need help? Contact
                        <a href="mailto:info@nceeic.org" class="text-gold hover:underline">info@nceeic.org</a>
                    </p>
                </div>
            </div>
        </div>

        {{-- Info note --}}
        <div class="mt-5 bg-blue-50 border border-blue-200 rounded-xl p-4 text-[12.5px] text-blue-800 flex gap-3">
            <i class="ti ti-info-circle text-blue-500 text-[16px] flex-shrink-0 mt-0.5"></i>
            <p>
                The verification email may take a few minutes to arrive. If you are using a government
                or institutional email, check with your IT department that emails from
                <strong>noreply@nceeic.org</strong> are not being blocked.
            </p>
        </div>
    </div>

</body>
</html>
