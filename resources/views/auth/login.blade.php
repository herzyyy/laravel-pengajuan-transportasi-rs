<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — {{ config('app.name', 'Transportasi RSAzra') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden">

    {{-- Background blur --}}
    <div class="absolute inset-0 -z-10" style="background: url('{{ asset('images/login-bg.svg') }}') center center / cover no-repeat; filter: blur(6px); transform: scale(1.05);"></div>

    {{-- Login Card --}}
    <div class="relative z-10 w-full max-w-3xl mx-4">
        <div class="flex rounded-2xl overflow-hidden" style="min-height: 360px; box-shadow: 0 8px 40px rgba(0,0,0,0.18), 0 2px 8px rgba(0,0,0,0.10);">

            {{-- Kiri: Branding --}}
            <div class="hidden sm:flex w-2/5 flex-col items-center justify-center px-8 py-10 text-white" style="background-color: #00685E;">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="bg-white rounded-2xl p-4 shadow-lg">
                        <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-16 w-auto">
                    </div>
                    <div>
                        <div class="text-xl font-bold tracking-tight">RS Azra</div>
                        <div class="text-xs text-emerald-200 mt-1 leading-relaxed">
                            Sistem Pengajuan<br>Transportasi
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Form --}}
            <div class="flex-1 bg-white flex flex-col justify-center px-8 py-10 relative">

                {{-- Mobile logo --}}
                <div class="sm:hidden flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-9 w-auto">
                    <div>
                        <div class="text-sm font-bold text-slate-800">RS Azra</div>
                        <div class="text-[10px] text-slate-500">Sistem Pengajuan Transportasi</div>
                    </div>
                </div>

                <h2 class="text-xl font-bold text-slate-800 mb-6">Selamat Datang!</h2>

                <form method="POST" action="{{ route('login.store') }}" class="space-y-4" x-data="{ showPass: false }">
                    @csrf

                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 mb-1">Username</label>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            value="{{ old('username') }}"
                            required autofocus autocomplete="username"
                            placeholder="Masukan username"
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('username') border-red-400 @enderror"
                        >
                        @error('username')
                            <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                :type="showPass ? 'text' : 'password'"
                                required
                                placeholder="Password"
                                class="w-full px-3 py-2 pr-10 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('password') border-red-400 @enderror"
                            >
                            <button type="button" @click="showPass = !showPass"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full py-2.5 text-sm font-semibold text-white rounded-lg transition hover:opacity-90 active:scale-[0.99] mt-2"
                            style="background-color: #00685E;">
                        Login
                    </button>
                </form>

                <p class="text-center text-[10px] text-slate-400 mt-6">© {{ date('Y') }} RS Azra</p>
            </div>

        </div>
    </div>

</body>
</html>
