<x-guest-layout :hide-header="true">
    <div class="h-screen flex bg-gray-50 w-full">
        <!-- Left Side - Login Form (40%) -->
        <div class="w-full lg:w-2/5 flex items-center justify-center bg-white h-full">
            <div class="w-full flex items-center justify-center p-4 lg:p-6">
                <div class="w-full max-w-sm px-4">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex flex-col items-center mb-4">
                        <div class="bg-white rounded-xl p-2 shadow-lg mb-2">
                            <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-10 w-auto">
                        </div>
                        <h1 class="text-lg font-bold text-gray-900 text-center">Sistem Pengajuan Transportasi</h1>
                        <p class="text-gray-600 text-xs">rs azra</p>
                    </div>

                    <!-- Login Card -->
                    <div class="space-y-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-0.5">Selamat Datang</h2>
                            <p class="text-gray-600 text-xs">Silakan masuk ke akun Anda</p>
                        </div>

                        <form method="POST" action="{{ route('login.store') }}" class="space-y-3">
                            @csrf

                            <!-- Username Field -->
                            <div>
                                <label for="username" class="block text-[11px] font-semibold text-gray-700 mb-1">
                                    Username
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        id="username"
                                        name="username"
                                        type="text"
                                        value="{{ old('username') }}"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        class="block w-full pl-9 pr-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-300 focus:border-slate-400 transition @error('username') border-red-500 @enderror"
                                        placeholder="namadepan.namabelakang"
                                    >
                                </div>
                                @error('username')
                                    <p class="mt-1 text-[10px] text-red-600 flex items-center">
                                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password" class="block text-[11px] font-semibold text-gray-700 mb-1">
                                    Kata Sandi
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        required
                                        class="block w-full pl-9 pr-3 py-2 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-300 focus:border-slate-400 transition @error('password') border-red-500 @enderror"
                                        placeholder="Masukkan kata sandi"
                                    >
                                </div>
                                @error('password')
                                    <p class="mt-1 text-[10px] text-red-600 flex items-center">
                                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                    class="h-3 w-3 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                >
                                <span class="ml-1.5 text-[11px] text-gray-700">Ingat saya</span>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="w-full py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-150 flex items-center justify-center space-x-1.5"
                            >
                                <span>Masuk</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Branding (60%) -->
        <div class="hidden lg:flex lg:w-3/5 bg-emerald-700 relative overflow-hidden h-full">
            <!-- Decorative Background Pattern -->
            <div class="absolute inset-0">
                <!-- Large Circles -->
                <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-teal-400/20 rounded-full translate-x-1/3 translate-y-1/3"></div>
                <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-emerald-400/15 rounded-full"></div>
                
                <!-- Grid Pattern -->
                <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full text-center px-8 py-8 h-full">
                <div class="w-full max-w-lg mx-auto space-y-8">
                    <!-- Logo -->
                    <div class="flex flex-col items-center space-y-5">
                        <div class="bg-white rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition duration-300 ring-4 ring-white/20">
                            <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-24 w-auto">
                        </div>
                        
                        <!-- Hospital Name -->
                        <div class="space-y-2">
                            <h1 class="text-5xl font-bold text-white drop-shadow-2xl tracking-tight">RS Azra</h1>
                            <p class="text-emerald-50 text-lg font-semibold tracking-wide">Rumah Sakit Bogor</p>
                        </div>
                    </div>
                    
                    <!-- Decorative Divider -->
                    <div class="flex items-center justify-center space-x-4 py-2">
                        <div class="h-0.5 bg-emerald-300/60 w-20"></div>
                        <div class="flex space-x-1.5">
                            <div class="w-1.5 h-1.5 bg-emerald-300/60 rounded-full animate-pulse"></div>
                            <div class="w-1.5 h-1.5 bg-emerald-300/60 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                            <div class="w-1.5 h-1.5 bg-emerald-300/60 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                        </div>
                        <div class="h-0.5 bg-emerald-300/60 w-20"></div>
                    </div>
                    
                    <!-- System Name -->
                    <div class="space-y-4 bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                        <h2 class="text-3xl font-bold leading-tight text-white drop-shadow-2xl">
                            Sistem Pengajuan<br>Transportasi
                        </h2>
                        <p class="text-emerald-50 text-base leading-relaxed font-light">
                            Platform digital untuk pengelolaan pengajuan transportasi yang efisien dan terorganisir
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
