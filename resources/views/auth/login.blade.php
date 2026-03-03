<x-guest-layout :hide-header="true">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding & Info -->
        <div class="hidden lg:flex lg:w-3/5 bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-teal-300 rounded-full blur-3xl"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center p-12 text-white w-full">
                <!-- Logo & Title -->
                <div class="mb-12">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="bg-white rounded-xl p-3 shadow-lg">
                            <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-12 w-auto">
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">RS Azra</h1>
                            <p class="text-emerald-100 text-sm">Rumah Sakit Bogor</p>
                        </div>
                    </div>
                    
                    <h2 class="text-3xl font-bold mb-4 leading-tight">
                        Sistem Pengajuan<br>Transportasi
                    </h2>
                    <p class="text-emerald-50 text-base leading-relaxed max-w-xl">
                        Platform digital untuk pengelolaan pengajuan transportasi yang efisien dan terorganisir
                    </p>
                </div>

                <!-- Features -->
                <div class="space-y-5 max-w-xl">
                    <div class="flex items-start space-x-4">
                        <div class="bg-emerald-500/30 rounded-lg p-2 flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-base mb-1">Pengajuan Cepat</h3>
                            <p class="text-emerald-100 text-sm leading-relaxed">Ajukan kebutuhan transportasi ambulance dan umum dengan mudah</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="bg-emerald-500/30 rounded-lg p-2 flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-base mb-1">Tracking Real-time</h3>
                            <p class="text-emerald-100 text-sm leading-relaxed">Pantau status pengajuan Anda secara langsung</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="bg-emerald-500/30 rounded-lg p-2 flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-base mb-1">Aman & Terpercaya</h3>
                            <p class="text-emerald-100 text-sm leading-relaxed">Data Anda terlindungi dengan sistem keamanan terbaik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-2/5 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex flex-col items-center mb-8">
                    <div class="bg-white rounded-lg p-3 shadow-md mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="RS Azra" class="h-16 w-auto">
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Sistem Pengajuan Transportasi</h1>
                    <p class="text-gray-600 text-sm">RS Azra</p>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat Datang</h2>
                        <p class="text-gray-600 text-sm">Silakan masuk ke akun Anda</p>
                    </div>

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                        @csrf

                        <!-- Username Field -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Nama Pengguna
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama pengguna"
                                >
                            </div>
                            @error('name')
                                <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 @error('password') border-red-500 @enderror"
                                    placeholder="Masukkan kata sandi"
                                >
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                    class="h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                >
                                <span class="ml-2 text-sm text-gray-700">Ingat saya</span>
                            </label>
                            <a href="#" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 transition duration-150">
                                Lupa kata sandi?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-150 flex items-center justify-center space-x-2"
                        >
                            <span>Masuk</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>

                    <!-- Demo Accounts -->
                    <div class="mt-6 pt-5 border-t border-gray-200">
                        <p class="text-xs text-gray-500 text-center mb-2.5 font-semibold uppercase tracking-wide">Akun Demo</p>
                        <div class="space-y-2">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-2.5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="bg-blue-500 rounded-full p-1">
                                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-blue-900">User</p>
                                            <p class="text-xs text-blue-700">Test User / password</p>
                                        </div>
                                    </div>
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full font-medium">Pegawai</span>
                                </div>
                            </div>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-2.5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="bg-purple-500 rounded-full p-1">
                                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-purple-900">Admin</p>
                                            <p class="text-xs text-purple-700">Administrator / password123</p>
                                        </div>
                                    </div>
                                    <span class="text-xs bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full font-medium">Admin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <p class="mt-4 text-center text-xs text-gray-500">
                    Dengan masuk, Anda menyetujui <a href="#" class="text-emerald-600 hover:underline">Syarat & Ketentuan</a> kami
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
